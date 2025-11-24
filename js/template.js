//Laden der Kursbezeichnung und den Kursleiter aus den Daten
function getCourse(data){
    let course = data.course;
    let firstTeacher = data.teacher;
    let secondTeacher = data.teacher;

    
    return `
    <div onclick="" class="course-card d-flex-c">
        <h2 class="course-card-title">${course}</h2>
        <p>${firstTeacher} / ${secondTeacher}</p>
    </div>
    `;
}