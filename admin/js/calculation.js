let x = -1;
let y = -1;
let result = -1;
let a = parseInt(document.getElementById('first-number').alt);
let b = parseInt(document.getElementById('second-number').alt);
let z = parseInt(document.getElementById('plus-or-minus').alt);
let correct;
if (z == 1) {
    correct = a + b;
} else {
    correct = a - b;
}
function input(element) {
    if(x<0){
        x = parseInt(element.id.slice(7,8));
        document.getElementById("img-x").src = element.src;
        result = x;
    } else if (y<0) {
        y = parseInt(element.id.slice(7,8));
        document.getElementById("img-y").src = element.src;
        result = x*10+y;
    } else {
        console.log(result);
    }
    if (result == correct) {
        document.getElementById('submit').setAttribute('data-bs-target', '#correct');
    } else {
        document.getElementById('submit').setAttribute('data-bs-target', '#incorrect');
    }
}
function resetInput() {
    x = -1;
    y = -1;
    document.getElementById("img-x").src = "";
    document.getElementById("img-y").src = "";
    document.getElementById('submit').setAttribute('data-bs-target', '#incorrect');
}