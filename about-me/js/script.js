/*
  This function toggles the visibility of a specific HTML element identified by the parameter "a" by changing its display style between "none" and "block".
  It also updates the inner HTML content of another element (presumably a button) to reflect the current state.
*/
function masque(a) {
  var div = document.getElementById("div" + a);
  var bp = document.getElementById("bp" + a);
  if (div.style.display === "none") {
    div.style.display = "block";
    bp.innerHTML = "Afficher -";
  } else {
    div.style.display = "none";
    bp.innerHTML = "Afficher +";
  }
}
