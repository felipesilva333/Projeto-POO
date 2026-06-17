$(function () {
    const url = $("span#url").text();

    let currentYear, currentMonth;
    let user_choices = {
        username: "",
        tel: "",
        barber: "",
        barberName: "",
        service: "",
        serviceName: "",
        date: "",
        time: "",
        message: "",
        user_id: document.querySelector("#user_id").value,
    };

    function showNotification(message) {
        $(".notification-overlay").addClass("notification-active");
        $(".notification-overlay").html(message);

        setTimeout(() => {
            $(".notification-overlay").removeClass("notification-active");
        }, 3000);
    }

    function hideConfirmationModal() {
        $(".modal-overlay").removeClass("modal-active");
        scrollToSection(".hero-section");
        resetAll();
    }

    function showConfirmationModal() {
        const { username, tel, email, barberName, serviceName, date, time, message } = user_choices;

        const splitedDate = String(date).split("-");
        const formattedDate = `${splitedDate[2].trim()}/${splitedDate[1].trim()}/${splitedDate[0].trim()}`;

        $(".modal-overlay").addClass("modal-active");
        $(".modal-body").html(`
            <h3>Confirmação do agendamento</h3>
            <p>Nome: ${username}</p>
            <p>Telefone para contato: ${tel}</p>
            <p>Email: ${email}</p>
            ${message ? `<p>Mensagem: ${message}</p>` : ``}
            <hr>
            <p>Barbeiro: ${barberName}</p>
            <p>Serviço: ${serviceName}</p>
            <p>Data: ${formattedDate}</p>
            <p>Horário: ${time}</p>
        `);

        $("#confirm_modal_btn").show();
    }

    function getMonthName(month) {
        const monthNames = [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro",
        ];
        return monthNames[month];
    }
    
    function fillWeekdays() {
        const weekdays = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"];
        const weekdaysContainer = $(".calendar-weekdays");
    
        weekdays.forEach(day => {
            weekdaysContainer.append("<div>" + day + "</div>");
        });
    }
    
    function fillCalendarContent(year, month) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const calendarContent = $(".calendar-content");
        calendarContent.empty();
    
        // Exemplo: Array de datas já agendadas (deve vir do seu backend)
        const bookedDates = [
            "2025-03-12", // Data já agendada
            "2025-03-15", // Data já agendada
            "2025-03-20"  // Data já agendada
        ];
    
        // Preencher os dias vazios do início do mês
        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarContent.append(`<button class="blank" title="Data vazia"></button>`);
        }
    
        const currentDate = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dateString = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
    
            // Verifica se a data está no array de datas já agendadas
            const isBooked = bookedDates.includes(dateString);
            
            // Se a data já estiver marcada, adiciona a classe 'unavailable' e desabilita o botão
            const dayClass = date < currentDate ? "passed" : "";
            const dayButtonClass = isBooked ? "unavailable" : "";
    
            calendarContent.append(
                `<button title="${isBooked ? "Data já agendada" : (date < currentDate ? "Data indisponível" : "Selecionar data")}"
                        data-time="${dateString}" class="${dayClass} ${dayButtonClass}"
                        ${isBooked ? 'disabled' : ''}>
                        ${day}
                </button>`
            );
        }
    }
    async function getBookedDates() {
        const response = await fetch(`${url}get_booked_dates`);
        const data = await response.json();
        return data.bookedDates; // Supondo que o backend retorna um array de datas agendadas
    }
    
    async function initializeCalendar() {
        const bookedDates = await getBookedDates(); // Obtemos as datas agendadas
        fillCalendarContent(currentYear, currentMonth, bookedDates);
        updateCurrentMonthYear();
    }    
    
    function updateCurrentMonthYear() {
        $(".current-month-year").text(getMonthName(currentMonth) + " de " + currentYear);
    }
    
    function initializeCalendar() {
        const currentDate = new Date();
        currentYear = currentDate.getFullYear();
        currentMonth = currentDate.getMonth();
    
        fillWeekdays();
        fillCalendarContent(currentYear, currentMonth);
        updateCurrentMonthYear();
    }

    function isDatetimeUnavailable(time, barberId, { data }) {
        const currentTime = new Date(time);
        const currentDate = new Date();
    
        if (currentTime < currentDate) {
            return true;
        }
    
        return data.some(
            (unavailableTime) =>
                unavailableTime.datetime == time && unavailableTime.barber_id == barberId
        );
    }

    async function fillTimeChoices(datetime, barberId) {
        const fetchData = await fetch(`${url}unavailable_datetime/get_all`);
        const unavailableTimes = await fetchData.json();
    
        const disponibleTimes = [
            "09:00", "09:30",
            "10:00", "10:30", "11:00", "11:30", "12:00", "12:30",
            "13:00", "13:30", "14:00", "14:30", "15:00", "15:30",
            "16:00", "16:30", "17:00", "17:30","18:00","18:30","19:00",
            "19:30","20:00",
        ];
    
        const timesContent = $(".time-buttons");
        timesContent.empty();
    
        for (let currentTime of disponibleTimes) {
            const check = `${datetime} ${currentTime}:00`;
    
            // Verificar se o horário está indisponível
            const isUnavailable = unavailableTimes.data.some(
                (unavailableTime) => unavailableTime.datetime === check && unavailableTime.barber_id === barberId
            );
    
            // Adiciona o botão de horário, aplicando a classe "unavailable" se for o caso
            timesContent.append(
                `<button type="button" class="${isUnavailable ? 'unavailable' : ''}" 
                    ${isUnavailable ? 'title="Horário indisponível" disabled' : 'title="Selecionar horário"'}>
                    ${currentTime}
                </button>`
            );
        }
    }
    

    function scrollToSection(sectionClass) {
        $([document.documentElement, document.body]).animate({ scrollTop: $(sectionClass).offset().top }, 500);
    }

    function handleBarberSelection() {
        user_choices.barber = $(this).attr("data-id");
        user_choices.barberName = $(this).attr("data-barber");

        $(".barbers-container .barber").removeClass("schedule-option-selected");
        $(this).addClass("schedule-option-selected");
    
        if (user_choices.date && user_choices.time) {
            scrollToSection(".service-section");
        } else {
            scrollToSection(".service-section");
        }
    }

    function handleServiceSelection() {
        user_choices.service = $(this).attr("data-id");
        user_choices.serviceName = $(this).attr("data-service");

        $(".services-container .service").removeClass("schedule-option-selected");
        $(this).addClass("schedule-option-selected");

        scrollToSection(user_choices.date && user_choices.time ? ".message-section" : ".datetime-section");
    }
   
    function handleTimeSelection() {
        user_choices.time = $(this).text();

        $(".time-buttons button").removeClass("schedule-option-selected");
        $(this).addClass("schedule-option-selected");

        if (user_choices.time && user_choices.date) {
            scrollToSection(".message-section");
        }
    }

    function handleDateSelection() {
        user_choices.date = $(this).attr("data-time");

        fillTimeChoices($(this).attr("data-time"), user_choices.barber);

        $(".calendar-content button").removeClass("schedule-option-selected");
        $(this).addClass("schedule-option-selected");

        if ($(window).width() < 768) scrollToSection(".time-column");
    }

    function handleConfirmation() {
        user_choices.username = $("#username_message").val() || "";
        user_choices.tel = $("#telephone_message").val() || "";
        user_choices.email = $("#email_message").val() || "";
        user_choices.message = $("#textarea_message").val() || "";
        
        if (!user_choices.barber) {
            showNotification("Escolha o barbeiro para continuar");
            scrollToSection(".barber-type-section");
            return;
        }

        if (!user_choices.service) {
            showNotification("Preencha o tipo de serviço para continuar");
            scrollToSection(".service-type-section");
            return;
        }

        if (!user_choices.date || !user_choices.time) {
            showNotification("Preencha a data e hora para continuar");
            scrollToSection(".datetime-section");
            return;
        }

        if (!user_choices.username || !user_choices.tel || !user_choices.email) {
            showNotification("Preencha seu nome, email e telefone para continuar");
            scrollToSection(".message-section");
            return;
        }

        showConfirmationModal();
    }

    function handleSubmit() {
        const { username, tel, email, barber, service, date, time, message, user_id } = user_choices;
        const datetime = `${date} ${time}:00`;

        $.post(`${url}schedule/create`, {
            username,
            tel,
            email,
            barber,
            service,
            datetime,
            message,
            user_id,
        }).done(function (data) {
            const response = JSON.parse(data);

            $(".modal-body").empty();
            $(".modal-body").append(`<p class="modal-alert">${response.message}</p>`);

            if (response.status === 200) {
                $("#confirm_modal_btn").hide();
            }
        });
    }

    function resetAll() {
        $(".barbers-container .barber").removeClass("schedule-option-selected");
        $(".services-container .service").removeClass("schedule-option-selected");
        $(".calendar-content button").removeClass("schedule-option-selected");
        $(".time-buttons-container").siblings("h3").hide();
        $(".time-buttons").empty();

        user_choices = {
            username: "",
            tel: "",
            email: "",
            barber: "",
            service: "",
            serviceName: "",
            date: "",
            time: "",
            message: "",
            user_id: document.querySelector("#user_id").value,
        };
    }

    function getPreviousMonth() {
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        currentYear -= currentMonth === 11 ? 1 : 0;

        updateCurrentMonthYear();
        fillCalendarContent(currentYear, currentMonth);
    }

    function getNextMonth() {
        currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
        currentYear += currentMonth === 0 ? 1 : 0;

        updateCurrentMonthYear();
        fillCalendarContent(currentYear, currentMonth);
    }

    $(".switch-left").click(getPreviousMonth);
    $(".switch-right").click(getNextMonth);
    $(".start-btn").click(() => scrollToSection(".service-type-section"));
    $(".barbers-container").on("click", ".barber", handleBarberSelection);
    $(".services-container").on("click", ".service", handleServiceSelection);
    $(".time-buttons").on("click", "button", handleTimeSelection);
    $(".calendar-content").on("click", "button:not(.blank, .passed)", handleDateSelection);
    $(".schedule-confirm").click(handleConfirmation);
    $("#modal_close").click(hideConfirmationModal);
    $("#confirm_modal_btn").click(handleSubmit);

    initializeCalendar();
});
