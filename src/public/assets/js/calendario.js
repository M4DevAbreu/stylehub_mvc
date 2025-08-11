document.addEventListener("DOMContentLoaded", function () {
    const monthPicker = document.getElementById("month-picker");
    const yearDisplay = document.getElementById("year");
    const calendarDays = document.getElementById("calendar-days");
    const prevMonthBtn = document.getElementById("prev-month");
    const nextMonthBtn = document.getElementById("next-month");
    const horariosDiv = document.getElementById("horarios");
    const dataSelecionadaSpan = document.getElementById("dataSelecionada");
    const listaHorarios = document.getElementById("lista-horarios");

    if (!monthPicker || !calendarDays) {
        console.error("Elementos do calendário não encontrados!");
        return;
    }

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const months = [
        "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
        "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
    ];

    function renderCalendar(month, year) {
        monthPicker.textContent = months[month];
        yearDisplay.textContent = year;
        calendarDays.innerHTML = "";

        let firstDay = new Date(year, month, 1).getDay();
        let daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            calendarDays.innerHTML += `<div class="empty"></div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement("div");
            dayElement.textContent = day;
            dayElement.classList.add("calendar-day");

            dayElement.addEventListener("click", function () {
                const data = `${String(day).padStart(2, "0")}/${String(month + 1).padStart(2, "0")}/${year}`;
                dataSelecionadaSpan.textContent = data;
                horariosDiv.classList.remove("d-none");

                // Exemplo de horários fixos
                listaHorarios.innerHTML = `
                    <button class="btn btn-outline-primary">08:00</button>
                    <button class="btn btn-outline-primary">09:00</button>
                    <button class="btn btn-outline-primary">10:00</button>
                `;
            });

            calendarDays.appendChild(dayElement);
        }
    }

    prevMonthBtn.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    });

    nextMonthBtn.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    });

    // Inicializa
    renderCalendar(currentMonth, currentYear);
});
