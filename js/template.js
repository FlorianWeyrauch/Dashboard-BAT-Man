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

//Dropdown Placeholder für Kursjahr auswählen
function getYearOptionPlaceholder(){
    return `
    <option value="" disabled selected hidden>Kursjahr auswählen</option>
    `;
}

function getCourseHeader(data){
    let course = data.courseName;
    let firstTeacher = data.firstLeader.firstName + ' ' + data.firstLeader.lastName;
    let secondTeacher = data.secondLeader.firstName + ' ' + data.secondLeader.lastName;
    return `
        <h2>${course}</h2>
        <p>Kursleiter: ${firstTeacher} / ${secondTeacher}</p>
    `;
}

function getStudent(data){
    return `
        <div class="student-row d-flex-sb-c c-pointer">
            <h4 class="student-name">${data.firstName} ${data.lastName}</h4>
            <h4 class="student-profession">${data.profession}</h4>
            <span class="status-traffic-light ${data.status}"></span>
        </div>
    `;
}
