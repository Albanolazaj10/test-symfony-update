
const product = document.getElementById('number').value; 


function decreaseValue() {
    var value = parseInt(document.getElementById('number').value);
    value--;
    document.getElementById('number').value = value;
}

function increaseValue() {
    var value = parseInt(document.getElementById('number').value);
    value++;
    document.getElementById('number').value = value;
}


if(submit) {
    submit.addEventListener('click', e => {
        if(e.target.className === "btn btn-success") {
            // if() {
            //     alert("Sorry, can't buy more than available products");
            // }
        }
    });
}



// UPDATE
// if(update) {
//     update.addEventListener('click', e => {
//         if(e.target.className === 'btn btn-outline-success') {
//             const id = e.target.getAttribute('data-id');
            
            
//             fetch(`/update/${id}`, {
//                 method: 'UPDATE',
//             }).then(res => window.location.reload());
//         }
//     });
// }