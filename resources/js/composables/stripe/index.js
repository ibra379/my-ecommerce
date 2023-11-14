import {ref} from "vue";

export default function useStripe(){

    const stripe = ref('');
    const elements = ref()
    const initialize = async ()=>{
        stripe.value = Stripe(import.meta.env.VITE_STRIPE_TEST_PUBLIC_KEY);

        const clientSecret = await axios.get('/paymentIntent')
            .then( res => res.data.clientSecret)
            .catch(err => console.log(err))

        elements.value = stripe.value.elements({ clientSecret });

        const paymentElement = elements.value.create("payment");
        paymentElement.mount("#payment-element");
    }

    const checkStatus = async () => {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        if (!clientSecret) {
            return;
        }

        const { paymentIntent } = await stripe.value.retrievePaymentIntent(clientSecret);

        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Payment succeeded!");
                break;
            case "processing":
                showMessage("Your payment is processing.");
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
            default:
                showMessage("Something went wrong.");
                break;
        }
    }

    const handleSubmit = async () => {
        setLoading(true);

        const { error } = await stripe.value.confirmPayment({
            elements: elements.value,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: `${import.meta.env.VITE_APP_URL}`,
                receipt_email: "idiallo379@gmail.com",
            },
        });

        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

        setLoading(false);
    }

    // ------- UI helpers -------

    const showMessage = (messageText) => {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 4000);
    }

// Show a spinner on payment submission
    const setLoading = (isLoading) => {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }

    return {
        initialize,
        checkStatus,
        handleSubmit
    }
}
