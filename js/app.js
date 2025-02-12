document.addEventListener("DOMContentLoaded", function(){
    //get current date.
    const today = new Date();

    //extract year, month, day and format to ensure two digits
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    //min date is the current date
    const minDate = `${year}-${month}-${day}`;



    //max date is 1 year into the future.
    const nextYear = new Date();
    nextYear.setFullYear(today.getFullYear() + 1);

    const maxYear = nextYear.getFullYear();
    const maxMonth = String(nextYear.getMonth() + 1).padStart(2, '0');
    const maxDay = String(nextYear.getDate()).padStart(2, '0');
    const maxDate = `${maxYear}-${maxMonth}-${maxDay}`;

    const dateField = document.getElementById("dateOfReservation");


    
    //client-side validation to make sure that the user cannot select a date in the past.
    if(dateField){
        dateField.setAttribute("min", minDate);
        dateField.setAttribute("max", maxDate);
    }
});