//Laden der Kursbezeichnung und den Kursleiter aus den Daten
function getCourse(data){
    let course = data.courseName;
    let firstTeacher = data.firstLeader;
    let secondTeacher = data.secondLeader;


    return `
    <div onclick="" class="course-card d-flex-c">
        <h2 class="course-card-title">${course}</h2>
        <p>${firstTeacher} / ${secondTeacher}</p>
    </div>
    `;
}