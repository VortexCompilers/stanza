/* Open and close the login / register pop-ups.

   HTML used attributes:
     data-abrir="idDoModal"   — open the pop-up
     data-fechar              — close the pop-up in which the element is
     data-trocar="idDoModal"  — close the current and open another

   The triggers are actual links (hrefs), so they continue
to function as navigation if this script fails to load.*/

document.addEventListener("click", function (evento) {

    const gatilhoAbrir = evento.target.closest("[data-abrir]");
    if (gatilhoAbrir) {
        evento.preventDefault();
        abrirModal(document.getElementById(gatilhoAbrir.dataset.abrir));
        return;
    }

    const gatilhoTrocar = evento.target.closest("[data-trocar]");
    if (gatilhoTrocar) {
        evento.preventDefault();
        fecharModal(gatilhoTrocar.closest(".modal"));
        abrirModal(document.getElementById(gatilhoTrocar.dataset.trocar));
        return;
    }

    const gatilhoFechar = evento.target.closest("[data-fechar]");
    if (gatilhoFechar) {
        evento.preventDefault();
        fecharModal(gatilhoFechar.closest(".modal"));
        return;
    }

    // dark back click, off the card
    if (evento.target.classList.contains("modal")) {
        fecharModal(evento.target);
    }

});


document.addEventListener("keydown", function (evento) {
    if (evento.key === "Escape") {
        fecharModal(document.querySelector(".modal.is-open"));
    }
});


function abrirModal(modal) {
    if (!modal) return;

    modal.classList.add("is-open");
    document.body.classList.add("no-scroll");

    const primeiroCampo = modal.querySelector("input, select");
    if (primeiroCampo) primeiroCampo.focus();
}


function fecharModal(modal) {
    if (!modal) return;

    modal.classList.remove("is-open");

    if (!document.querySelector(".modal.is-open")) {
        document.body.classList.remove("no-scroll");
    }
}
