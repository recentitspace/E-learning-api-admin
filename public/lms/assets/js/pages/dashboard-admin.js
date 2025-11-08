"use strict";
let getInstructorByMonth = $("#getInstructorByMonth").val();
let instructorMonth = $("#instructorMonth").val();
instructorMonth = JSON.parse(instructorMonth);
getInstructorByMonth = JSON.parse(getInstructorByMonth);
let studentDate = $("#studentDate").val();
let getStudentByDate = $("#getStudentByDate").val();
studentDate = JSON.parse(studentDate);
getStudentByDate = JSON.parse(getStudentByDate);

// instructor Student register chart.
const instructorStudent = {
    chart: {
        type: "area",
        height: 320,
        width: "100%",
        offsetX: -5,
        offsetY: 15,
        toolbar: {
            show: false,
        },
        events: {
            mounted: (chart) => {
                chart.windowResizeHandler();
            },
        },
    },
    xaxis: {
        categories: studentDate,
        offsetX: 4,
    },
    yaxis: {
        min: 5,
        max: 90,
        tickAmount: 5,
        labels: {
            formatter: (val) => val,
        },
    },
    series: [
        {
            name: registerInstructor,
            data: getInstructorByMonth,
        },
        {
            name: studentInstructor,
            data: getStudentByDate,
        },
    ],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "18%",
            endingShape: "rounded",
        },
    },
    grid: {
        borderColor: "#EEE",
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "straight",
        colors: ["#795DED", "#76D466"],
        width: 2.5,
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: 0.4,
            opacityTo: 0.15,
            stops: [0, 60],
        },
    },
    legend: {
        position: "top",
        horizontalAlign: "left",
        offsetX: -30,
        offsetY: 0,
        markers: {
            width: 7,
            height: 7,
            radius: 99,
            fillColors: ["#795DED", "#76D466"],
            offsetX: -3,
            offsetY: -1,
        },
        itemMargin: {
            horizontal: 20,
        },
    },
    tooltip: {
        y: {
            formatter: (val) => {
                return val;
            },
        },
    },
};

const averageEnroll = new ApexCharts(
    document.querySelector("#instructor-student-chart"),
    instructorStudent
);
averageEnroll.render();