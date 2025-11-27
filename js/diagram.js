function renderCourseDiagram(course) {
    const canvas = document.getElementById('pieChart');
    const legendContainer = document.getElementById('legend');
    const diagramData = drawPieChart(canvas, course);
    createLegend(diagramData);
}

function drawPieChart(canvas, course) {
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(centerX, centerY) - 20;
    
    let statusCount = { green: 0, yellow: 0, red: 0 };
    course.students.forEach(student => {
        statusCount[student.status]++;
    });
    
    const data = [
        { label: 'Grün', value: statusCount.green, color: '#00ff00' },
        { label: 'Gelb', value: statusCount.yellow, color: '#ffff00' },
        { label: 'Rot', value: statusCount.red, color: '#ff0000' }
    ];
    
    const total = course.students.length;
    let currentAngle = -Math.PI / 2;
    
    data.forEach((element) => {
        if (element.value === 0) return;
        
        const sliceAngle = (item.value / total) * 2 * Math.PI;
        
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        ctx.closePath();
        ctx.fillStyle = element.color;
        ctx.fill();
        ctx.strokeStyle = '#fff';
        ctx.lineWidth = 3;
        ctx.stroke();
        
        currentAngle += sliceAngle;
    });
    
    return data;
}

function createLegend(data) {
    const legend = document.getElementById('legend');
    legend.innerHTML = '';
    
    data.forEach(item => {
        const legendItem = document.createElement('div');
        legendItem.className = 'legend-item';
        
        const colorBox = document.createElement('div');
        colorBox.className = 'legend-color';
        colorBox.style.backgroundColor = item.color;
        
        const label = document.createElement('span');
        label.textContent = `${item.label}: ${item.value}`;
        
        legendItem.appendChild(colorBox);
        legendItem.appendChild(label);
        legend.appendChild(legendItem);
    });
}