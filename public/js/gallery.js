let productImg = document.getElementById('product-img')
let smallImg = document.querySelectorAll('.small-img')

smallImg.forEach((item) => {
    item.onclick = () => {
        productImg.src = item.src
    }
})
