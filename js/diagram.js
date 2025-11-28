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
    let data = [
        { label: 'Niedrig', value: statusCount.red, color: '#ff0000' },
        { label: 'Hoch', value: statusCount.yellow, color: '#ffe500' },
        { label: 'Vertrag', value: statusCount.green, color: '#00e600' }
    ];
    const total = course.students.length;
    let currentAngle = -Math.PI / 2;    
    data.forEach((element) => {
        if (element.value === 0) return;
        const sliceAngle = (element.value / total) * 2 * Math.PI;        
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