function loadCurrentStudents() {
    let courseHeader = document.getElementById('course_header');
    let courseContainer = document.getElementById('course_student_display');
    let students = [];
    let currentCourse = getFromSessionStorage('selectedCourse');
    currentCourse.students.forEach(element => {
        students.push(element);
        bubbleSortStudents(students);
    });
    courseHeader.innerHTML = getCourseHeader(currentCourse);
    courseContainer.innerHTML = "";
    students.forEach(element => {
        courseContainer.innerHTML += getStudent(element);
    });
    clearStudentOverview();    
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

function filterStudent() {
    let nameInput = document.getElementById("name_input");
    let professionSelect = document.getElementById("profession_selection");
    let statusSelect = document.getElementById("status_selection");
    let courseContainer = document.getElementById('course_student_display');
    let currentCourse = getFromSessionStorage('selectedCourse');
    
    let nameFilter = nameInput.value.toLowerCase();
    let selectedProfession = professionSelect.value;
    let selectedStatus = statusSelect.value;
    
    courseContainer.innerHTML = '';
    
    currentCourse.students.forEach(element => {
        let fullName = (element.firstName + ' ' + element.lastName).toLowerCase();
        let matchesName = nameFilter === "" || fullName.includes(nameFilter);
        let matchesProfession = selectedProfession === "" || element.profession.toLowerCase() === selectedProfession.toLowerCase();
        let matchesStatus = selectedStatus === "" || element.status.toLowerCase() === selectedStatus.toLowerCase();
        
        if (matchesName && matchesProfession && matchesStatus) {
            courseContainer.innerHTML += getStudent(element);
        }
    });
}

function clearStudentOverview() {
    let name = document.getElementById("name_input");
    let profession = document.getElementById("profession_selection");
    let status = document.getElementById("status_selection");
    name.value = "";
    profession.value = "";
    status.value = "";
}

console.log(Math.min(10, 10))
