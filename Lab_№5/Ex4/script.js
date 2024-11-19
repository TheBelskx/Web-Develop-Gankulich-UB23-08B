function checkPalindrome() {
    const word = document.getElementById("wordInput").value.toLowerCase();
    const reversedWord = word.split("").reverse().join("");
  
    const resultElement = document.getElementById("result");
  
    if (word === reversedWord) {
      resultElement.textContent = `"${word}" - это палиндром!`;
      resultElement.style.color = "green"; // Зеленый цвет для успешной проверки
    } else {
      resultElement.textContent = `"${word}" - это не палиндром.`;
      resultElement.style.color = "red"; // Красный цвет для неудачной проверки
    }
  }