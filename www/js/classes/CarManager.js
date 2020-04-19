class CarManager
{
    constructor()
    {
        this.handleAddCarFormSend();
    }

    handleAddCarFormSend()
    {
        const form = document.querySelector("#_add-car-form");

        form.addEventListener("submit", event => this.validateAddForm(form, event));
    }

    validateAddForm(form, event)
    {
        const name = document.querySelector("#_car-name-input").value;
        const dayPrice = document.querySelector("#_car-day-price-input").value;
        const image = document.querySelector("#_car-image-input").value;

        if(name === "" || dayPrice === "" || image === "") {
            event.preventDefault();
            this.showFormError(form, "Nebyla vyplněna všechna pole");
        }

        if(/^\d+$/u.test(dayPrice) === false) {
            event.preventDefault();
            this.showFormError(form, "Neplatný formát ceny");
        }
    }

    showFormError(form, errorMessage)
    {
        let errorElement;
        if((errorElement = form.querySelector("._error-message")) === null) {
            errorElement = document.createElement("p");
            errorElement.classList.add("form-message");
            errorElement.classList.add("_error-message");

            form.append(errorElement);
        }

        errorElement.textContent = errorMessage;
    }
}