let livreModalContent = document.getElementById("livreModalContent");
document.querySelectorAll(".showLivre").forEach((btn) =>
{
    btn.addEventListener("click", (e) =>
    {
        // console.log("clic")
        fetch(btn.value).then(response => response.text()).then(text =>
        {
            livreModalContent.innerHTML = text;
        })
    })
})