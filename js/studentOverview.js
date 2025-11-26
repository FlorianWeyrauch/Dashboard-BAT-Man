function loadCurrentStudents() {
    let courseHeader = document.getElementById('course_header');
    let courseContainer = document.getElementById('course_student_display');
    let students = [];
    const currentCourse = getFromSessionStorage('selectedCourse');
    currentCourse.students.forEach(element => {
        students.push(element);
        bubbleSortStudents(students);
    });
    courseHeader.innerHTML = getCourseHeader(currentCourse);
    students.forEach(element => {
        courseContainer.innerHTML += getStudent(element);
    });    
}

function bubbleSortStudents(arr) {
    let n = arr.length;
    for (let i = 0; i < n - 1; i++) {
        for (let j = 0; j < n - i - 1; j++) {
            if (arr[j].lastName > arr[j + 1].lastName) {
                let temp = arr[j];
                arr[j] = arr[j + 1];
                arr[j + 1] = temp;
            }
        }
    }
    return arr;
}
