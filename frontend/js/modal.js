/* Abre e fecha os pop-ups de acesso (login / cadastro).

   Atributos usados no HTML:
     data-abrir="idDoModal"   — abre o pop-up
     data-fechar              — fecha o pop-up em que o elemento está
     data-trocar="idDoModal"  — fecha o atual e abre outro

   Os gatilhos são links de verdade (href), então continuam
   funcionando como navegação caso este script não carregue. */

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

    // clique no fundo escuro, fora do cartão
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
