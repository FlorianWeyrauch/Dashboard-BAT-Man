//Laden der Kursbezeichnung und den Kursleiter aus den Daten
function getCourse(data, index){
    let course = data.courseName;
    let firstTeacher = data.firstLeader;
    let secondTeacher = data.secondLeader;


    return `
    <div onclick="showCurrentCourse(${index})" class="c-pointer course-card d-flex-c">
        <h2 class="course-card-title">${course}</h2>
        <p>${firstTeacher} / ${secondTeacher}</p>
    </div>
    `;
}