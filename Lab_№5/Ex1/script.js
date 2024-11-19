function showMushroomCount() {
    const count = parseInt(document.getElementById("mushroomCount").value);
    let ending;
  
    if (isNaN(count)) {
      document.getElementById("result").textContent = "Введите число!";
      return;
    }
  
    if (count === 1) {
      ending = "гриб";
    } else if (count >= 2 && count <= 4) {
      ending = "гриба";
    } else if (count % 10 === 1 && count % 100 !== 11) {
        ending = "гриб";
    } else if (count % 10 >= 2 && count % 10 <= 4 && (count % 100 < 10 || count % 100 >= 20)) {
      ending = "гриба";
    } else {
      ending = "грибов";
    }
  
    document.getElementById("result").textContent = `${count} ${ending}`;
    console.log(`${count} ${ending}`);
  }