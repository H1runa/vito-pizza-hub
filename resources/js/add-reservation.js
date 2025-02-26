import './bootstrap';  // Import Laravel Bootstrap helper

document.addEventListener("DOMContentLoaded", function () {
    // Attach event listener to the modal when it's opened dynamically
    document.body.addEventListener("click", function (event) {
        if (event.target.id === "checkForCustomer") {
            event.preventDefault();
            checkForCustomer();
        }
    });
});

// Fetch customer name based on username
async function checkForCustomer() {
    const enteredUsername = document.getElementById("customer").value;
    if (!enteredUsername) return;

    const url = new URL(window.customerNameRoute);
    url.searchParams.append("username", enteredUsername);

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Network error");

        const data = await response.json();
        document.getElementById("fullname").value = data.fullName;
    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("fullname").value = "Invalid";
    }
}

// Disable tables with overlapping reservation times
function checkAvailability() {
    const date = document.getElementById("date").value;
    const stime = document.getElementById("stime").value;
    const etime = document.getElementById("etime").value;

    if (!date || !stime || !etime) return;

    let nonoTables = [];

    reservationsData.forEach((reservation) => {
        const rDate = reservation.reserveDate;
        const rStime = reservation.startTime;
        const rEtime = reservation.endTime;

        if (date === rDate) {
            if ((stime >= rStime && stime <= rEtime) || (etime <= rEtime && etime >= rStime)) {
                nonoTables.push(reservation.tableID);
            }
        }
    });

    // Disable conflicting tables
    const tableSelect = document.getElementById("tableSelect");
    for (let opt of tableSelect.options) {
        opt.disabled = nonoTables.includes(parseInt(opt.value));
    }
}
