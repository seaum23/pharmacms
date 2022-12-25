import './bootstrap';

// let form = document.querySelector("#form_submit");

// form.addEventListener("submit", (e) => {
//     e.preventDefault();
//     let phone = document.querySelector("#phone").value;
//     let password = document.querySelector("#password").value;
//     let remember_me = document.querySelector("#remember_me").checked;
//     axios.post('/login', {
//         phone,
//         password,
//         remember_me
//     })
//     .then(function (response) {
//         console.log(response);
//     })
//     .catch(function (error) {
//         console.log(error);
//     });
// });

// let registration = document.querySelector("#registration_submit");

// registration.addEventListener("submit", (e) => {
//     e.preventDefault();
//     let user = document.querySelector("#user").value;
//     let formData = new FormData(registration);
//     axios.post(`/staff/${user}`, formData)
//     .then(function (response) {
//         console.log(response);
//     })
//     .catch(function (error) {
//         console.log(error);
//     });
// });

// let customer = document.querySelector("#customer_submit");

// customer.addEventListener("submit", (e) => {
//     e.preventDefault();
//     let formData = new FormData(customer);
//     axios.post('/customer', formData)
//     .then(function (response) {
//         console.log(response);
//     })
//     .catch(function (error) {
//         console.log(error);
//     });
// });

// let registration = document.querySelector("#registration_submit");

// registration.addEventListener("submit", (e) => {
//     e.preventDefault();
//     let user = document.querySelector("#user").value;
//     let formData = new FormData(registration);
//     axios.post(`/password/${user}`, formData)
//     .then(function (response) {
//         console.log(response);
//     })
//     .catch(function (error) {
//         console.log(error);
//     });
// });

let medicine = document.querySelector("#add_medicine");

medicine.addEventListener("submit", (e) => {
    e.preventDefault();
    let formData = new FormData(medicine);
    axios.post('/medicine', formData)
    .then(function (response) {
        console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    });
});


let logout = document.querySelector("#logout");
logout.addEventListener("submit", (e) => {
    axios.post('/logout', { })
    .then(function (response) {
        console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    });
});
