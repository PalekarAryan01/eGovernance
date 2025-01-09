document.getElementById("feesForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let studentId = document.getElementById("studentId").value;
    let fees = document.getElementById("fees").value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "feesManage.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById("r_studentId").innerText = response.studentId;
                    document.getElementById("r_fees").innerText = response.fees;
                    document.getElementById("receipt").style.display = "block";
                } else {
                    alert(response.message);
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e, xhr.responseText);
                alert("Error parsing JSON response. Check console for details.");
            }
        } else {
            alert("An error occurred while processing your request.");
        }
    };
    xhr.send(`studentId=${studentId}&fees=${fees}`);
});
