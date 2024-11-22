let currentValue = "0";
let operator = null;

function appendNumber(num) {
  if (currentValue === "0") {
    currentValue = num;
  } else {
    currentValue += num;
  }
  document.getElementById("display").value = currentValue;
}

function appendOperator(op) {
  operator = op;
  currentValue += op;
  document.getElementById("display").value = currentValue;
}

function calculate(op) {
    try{
        let result = eval(currentValue); // Не очень безопасный вариант. Используйте библиотеки mathjs для безопасных вычислений.
        currentValue = result.toString();
        document.getElementById("display").value = currentValue;
        operator = null;
    }catch(e){
        document.getElementById("display").value = "Error";
        currentValue = "0";
    }
}


function clearAll() {
  currentValue = "0";
  document.getElementById("display").value = currentValue;
  operator = null;
}

function clearEntry() {
  currentValue = "0";
  document.getElementById("display").value = currentValue;
}

function backspace() {
  currentValue = currentValue.slice(0, -1) || "0"; //Учитываем случай, когда очищается всё
  document.getElementById("display").value = currentValue;
}

function negate() {
  currentValue = (-parseFloat(currentValue)).toString();
  document.getElementById("display").value = currentValue;
}

function showGreeting() {
  alert("Ваш покорный слуга и программист - TheBelskx");
}