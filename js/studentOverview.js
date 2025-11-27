let currentCourse = getFromSessionStorage('selectedCourse');

function init(){
    loadCurrentStudents();
    renderCourseDiagram(currentCourse);
}

function renderCourseDiagram(course) {
    const canvas = document.getElementById('pieChart');
    const diagramData = drawPieChart(canvas, course);
    createLegend(diagramData);
}

function drawPieChart(canvas, course) {
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(centerX, centerY) - 10;
    
    let statusCount = { green: 0, yellow: 0, red: 0 };
    course.students.forEach(student => {
        statusCount[student.status]++;
    });
    
    const data = [
        { label: 'Niedrig', value: statusCount.red, color: '#ff0000' },
        { label: 'Hoch', value: statusCount.yellow, color: '#ffe500' },
        { label: 'Vertrag', value: statusCount.green, color: '#00e600' }
    ];
    
    const total = course.students.length;
    let currentAngle = -Math.PI / 2;

    console.log(currentAngle);
    
    data.forEach((element) => {
        if (element.value === 0) return;
        
        const sliceAngle = (element.value / total) * 2 * Math.PI;
        console.log(sliceAngle);
        
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        ctx.closePath();
        ctx.fillStyle = element.color;
        ctx.fill();
        ctx.lineWidth = 1;
        ctx.stroke();
        
        currentAngle += sliceAngle;
    });
    
    return data;
}

function createLegend(data) {
    const legend = document.getElementById('legend');
    legend.innerHTML = '';
    for(let i = data.length - 1; i >= 0; i--){
        legend.innerHTML += getLegendLabel(data[i]);
    }
}

function loadCurrentStudents() {
    let courseHeader = document.getElementById('course_header');
    let courseContainer = document.getElementById('course_student_display');
    let students = [];
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
