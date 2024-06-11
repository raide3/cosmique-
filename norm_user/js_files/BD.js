document.addEventListener('DOMContentLoaded', function () {
    var datePicker = document.getElementById('datePicker');

    // Définir les options du date picker
    var options = {
        dateFormat: "dd/mm/yy",
        maxDate: new Date(),
        changeMonth: true,
        changeYear: true
    };

    // Initialiser le date picker
    $(datePicker).datepicker(options);
});

