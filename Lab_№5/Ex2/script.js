function processArray() {
    const inputString = document.getElementById("arrayInput").value;
    const arr = inputString.split(",").map(Number);
  
    if (!arr.every(Number.isFinite)) {
      document.getElementById("sumResult").textContent = "Ошибка: некорректный ввод массива.";
      return;
    }
  
    let sum = 0;
    let lastNegativeCosineIndex = -1;
  
    for (let i = 0; i < arr.length; i++) {
      const cosine = Math.cos(arr[i]);
      if (cosine < 0) {
        lastNegativeCosineIndex = i;
      }
      if (lastNegativeCosineIndex !== -1 && i <= lastNegativeCosineIndex) {
        sum += arr[i];
      }
    }
  
    const filteredArray = arr.filter(num => {
      const intPart = Math.trunc(num);
      const absIntPart = Math.abs(intPart);
      return isSumOfDigitsEven(absIntPart);
    });
  
    document.getElementById("sumResult").textContent = `Сумма элементов до последнего отрицательного косинуса: ${sum}`;
    document.getElementById("filteredArrayResult").textContent = `Отфильтрованный массив: ${filteredArray}`;
  }
  
  function isSumOfDigitsEven(num) {
    const sum = String(num)
      .split("")
      .reduce((acc, digit) => acc + parseInt(digit), 0);
    return sum % 2 === 0;
  }