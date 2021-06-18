let a = -1;
function getRowId (element) {
  a = element.value;
}
function toDelete () {
  window.location.href = "category-delete.php?id=" + a;
}