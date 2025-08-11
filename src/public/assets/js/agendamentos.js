function confirmarAgendamento(id) {
    if (confirm("Deseja confirmar este agendamento?")) {
        fetch(`/agendamento/confirmar/${id}`, {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Agendamento confirmado!");
                location.reload();
            } else {
                alert("Erro ao confirmar.");
            }
        });
    }
}

function recusarAgendamento(id) {
    if (confirm("Deseja recusar este agendamento?")) {
        fetch(`/agendamento/recusar/${id}`, {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Agendamento recusado!");
                location.reload();
            } else {
                alert("Erro ao recusar.");
            }
        });
    }
}
