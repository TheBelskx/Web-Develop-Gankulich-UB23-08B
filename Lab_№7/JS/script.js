let displayValue = "0";
let pendingOperator = null;
let prevNumber = null;

function updateDisplay() {
  document.getElementById("display").value = displayValue;
}

function appendNumber(num) {
  if (displayValue === "0") {
    displayValue = num;
  } else {
    displayValue += num;
  }
  updateDisplay();
}


function appendOperator(op) {
  if (pendingOperator) {
    calculate();
  }
  prevNumber = displayValue;
  pendingOperator = op;
  displayValue = "0";
  updateDisplay();
}

function calculate() {
  const num1 = parseFloat(prevNumber);
  const num2 = parseFloat(displayValue);
  switch (pendingOperator) {
    case '+':
      displayValue = (num1 + num2).toString();
      break;
    case '-':
      displayValue = (num1 - num2).toString();
      break;
    case '*':
      displayValue = (num1 * num2).toString();
      break;
    case '/':
      if (num2 === 0) {
        displayValue = "Error: Division by zero";
      } else {
        displayValue = (num1 / num2).toString();
      }
      break;
  }
  pendingOperator = null;
  prevNumber = null;
  updateDisplay();
}

function clearDisplay() {
  displayValue = "0";
  pendingOperator = null;
  prevNumber = null;
  updateDisplay();
}

function clearEntry() {
  displayValue = "0";
  updateDisplay();
}

function backspace() {
  displayValue = displayValue.slice(0, -1) || "0";
  updateDisplay();
}

function negate() {
  displayValue = (-parseFloat(displayValue)).toString();
  updateDisplay();
}

function sqrt() {
  const num = parseFloat(displayValue);
  if (num < 0) {
    displayValue = "Error: Cannot calculate square root of a negative number";
  } else {
    displayValue = Math.sqrt(num).toString();
  }
  updateDisplay();
}

function inverse() {
  const num = parseFloat(displayValue);
  if (num === 0) {
    displayValue = "Error: Division by zero";
  } else {
    displayValue = (1 / num).toString();
  }
  updateDisplay();
}

function percent() {
  displayValue = (parseFloat(displayValue) / 100).toString();
  updateDisplay();
}

function showGreeting() {
  alert("Ваш покорный слуга и программист - TheBelskx");
}