document.addEventListener("DOMContentLoaded", function () {
    const calendarDays = document.getElementById("calendar-days");
    const monthPicker = document.getElementById("month-picker");
    const yearDisplay = document.getElementById("year");
    const horariosDiv = document.getElementById("horarios");
    const listaHorarios = document.getElementById("lista-horarios");
    const dataSelecionadaSpan = document.getElementById("dataSelecionada");
    const valorTotalSpan = document.getElementById("valor-total");
    const comentariosInput = document.getElementById("comentarios");
    const agendarBtn = document.getElementById("agendar-btn");

    let dataSelecionada = null;
    let horarioSelecionado = null;
    let mesAtual = new Date().getMonth();
    let anoAtual = new Date().getFullYear();

    const meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];

    function carregarCalendario() {
        calendarDays.innerHTML = "";
        monthPicker.textContent = meses[mesAtual];
        yearDisplay.textContent = anoAtual;

        let primeiroDia = new Date(anoAtual, mesAtual, 1).getDay();
        let diasNoMes = new Date(anoAtual, mesAtual + 1, 0).getDate();

        for (let i = 0; i < primeiroDia; i++) {
            calendarDays.innerHTML += `<div></div>`;
        }

        for (let dia = 1; dia <= diasNoMes; dia++) {
            let div = document.createElement("div");
            div.classList.add("day");
            div.textContent = dia;

            div.addEventListener("click", () => {
                document.querySelectorAll(".day").forEach(d => d.classList.remove("selected"));
                div.classList.add("selected");
                dataSelecionada = `${dia}/${mesAtual + 1}/${anoAtual}`;
                dataSelecionadaSpan.textContent = dataSelecionada;
                mostrarHorarios();
            });

            calendarDays.appendChild(div);
        }
    }

    function mostrarHorarios() {
        horariosDiv.classList.remove("d-none");
        listaHorarios.innerHTML = "";
        const horarios = ["09:00","10:00","11:00","14:00","15:00","16:00"];

        horarios.forEach(hora => {
            let btn = document.createElement("button");
            btn.textContent = hora;
            btn.classList.add("horario-btn");
            btn.addEventListener("click", () => {
                document.querySelectorAll(".horario-btn").forEach(b => b.classList.remove("selected-horario"));
                btn.classList.add("selected-horario");
                horarioSelecionado = hora;
            });
            listaHorarios.appendChild(btn);
        });
    }

    document.getElementById("prev-month").addEventListener("click", () => {
        mesAtual = (mesAtual - 1 + 12) % 12;
        if (mesAtual === 11) anoAtual--;
        carregarCalendario();
    });

    document.getElementById("next-month").addEventListener("click", () => {
        mesAtual = (mesAtual + 1) % 12;
        if (mesAtual === 0) anoAtual++;
        carregarCalendario();
    });

    document.querySelectorAll(".servico-checkbox").forEach(chk => {
        chk.addEventListener("change", () => {
            let total = 0;
            document.querySelectorAll(".servico-checkbox:checked").forEach(c => {
                total += parseFloat(c.dataset.preco);
            });
            valorTotalSpan.textContent = `R$ ${total.toFixed(2).replace(".", ",")}`;
        });
    });

    agendarBtn.addEventListener("click", async () => {
        if (!dataSelecionada || !horarioSelecionado) {
            alert("Selecione uma data e um horário antes de confirmar!");
            return;
        }

        const servicosSelecionados = [...document.querySelectorAll(".servico-checkbox:checked")].map(c => c.value);
        const precoTotal = valorTotalSpan.textContent.replace("R$ ", "").replace(",", ".");
        const comentarios = comentariosInput.value.trim();

        const dados = {
            data: dataSelecionada,
            horario: horarioSelecionado,
            servicos: servicosSelecionados,
            total: parseFloat(precoTotal),
            comentarios: comentarios
        };

        try {
            const resposta = await fetch("/agendamento/salvar", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(dados)
            });

            const resultado = await resposta.json();

            if (resposta.ok && resultado.sucesso) {
                new bootstrap.Modal(document.getElementById("modalConfirmacao")).show();
                console.log("Agendamento enviado com sucesso para o barbeiro!");
            } else {
                alert("Erro ao salvar o agendamento: " + (resultado.mensagem || "Tente novamente."));
            }
        } catch (erro) {
            console.error("Erro na requisição:", erro);
            alert("Não foi possível conectar ao servidor.");
        }
    });

    carregarCalendario();
});
