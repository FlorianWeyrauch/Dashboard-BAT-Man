//Laden der Kursbezeichnung und den Kursleiter aus den Daten
function getCourse(data, index){
    let course = data.courseName;
    let firstTeacher = data.firstLeader.firstName + ' ' + data.firstLeader.lastName;
    let secondTeacher = data.secondLeader.firstName + ' ' + data.secondLeader.lastName;


    return `
    <div onclick="showCurrentCourse(${index})" class="c-pointer course-card d-flex-c">
        <h2 class="course-card-title">${course}</h2>
        <p>${firstTeacher} / ${secondTeacher}</p>
    </div>
    `;
}

// Alle zur Verfügung stehenden Jahre aus den Kursen (DB)
function getYearOption(year){
    return `
    <option value="${year}">${year}</option>
    `;
}

function getYearOptionPlaceholder(){
    return `
    <option value="" disabled selected hidden>Kursjahr auswählen</option>
    `;
}
