function submitForm(event) {
    event.preventDefault();
    const form = event.target;
    const resultDiv = form.nextElementSibling;

    resultDiv.innerHTML = ""; 

    if (!validateForm()) return; 

    const outputDiv = document.createElement('div');
    outputDiv.className = 'result';

    let output = "";
    const formData = new FormData(form);
    for (const [key, value] of formData) {
        output += `${key}: ${value}\n`;
    }
    outputDiv.innerHTML = output; 

    form.insertBefore(outputDiv, form.querySelector('button'));


    form.reset(); 
}

function validateForm() {
    const form = document.querySelector('.registration-form');
    const errors = [];

    const carMake = form.carMake.value.trim();
    const carModel = form.carModel.value.trim();
    const year = parseInt(form.year.value);
    const mileage = parseInt(form.mileage.value);
    const price = parseInt(form.price.value);
    const description = form.description.value.trim();
    const contact = form.contact.value.trim();
    const email = form.email.value.trim();

// Более сложная и надежная валидация
    if (!carMake) errors.push("Марка автомобиля не может быть пустой.");
    if (!carModel) errors.push("Модель автомобиля не может быть пустой.");
    if (isNaN(year) || year < 1900 || year > 2024) errors.push("Укажите корректный год выпуска (1900-2024).");
    if (isNaN(mileage) || mileage < 0) errors.push("Укажите корректный пробег.");
    if (isNaN(price) || price < 0) errors.push("Укажите корректную цену.");
    if (!description) errors.push("Описание не может быть пустым.");
    if (!contact || !/^\+7\d{10}$/.test(contact)) errors.push("Укажите корректный номер телефона (например, +71234567890).");
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push("Некорректный email.");

    if (errors.length > 0) {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'error';
        errors.forEach(err => errorContainer.innerHTML += `<p>${err}</p>`);
        form.insertBefore(errorContainer, form.querySelector('button'));
        return false;
    }
    return true;
}