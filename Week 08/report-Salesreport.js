document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('salesByProducts').addEventListener('click', function () {
        if (confirm("Are you sure you want to generate the report for total dollar and quantity sales by products?")) {
            window.location.href = "report-generate.php?type=product";
        }
    });

    document.getElementById('salesByCategories').addEventListener('click', function () {
        if (confirm("Are you sure you want to generate the report for total dollar and quantity sales by categories?")) {
            window.location.href = "report-generate.php?type=category";
        }
    });
});
