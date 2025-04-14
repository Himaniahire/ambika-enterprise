
    // Number format function (if you use it in ticks/tooltips)
    function number_format(number, decimals = 0, dec_point = ".", thousands_sep = ",") {
        // Ensure number is a valid number
        number = Number(number);
        if (isNaN(number)) return ''; // Return empty string for invalid number

        // Default settings for decimals, thousands_sep, and dec_point
        let n = number,
            prec = Math.abs(decimals),
            sep = thousands_sep,
            dec = dec_point,
            s = '';

        // Handling rounding with precision
        const toFixedFix = (n, prec) => {
            const k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };

        // Handling fixed decimals
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

        // Add thousands separator
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        // Handle decimals
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        return s.join(dec);
    }


    fetch("/api/chart-data")
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById("myBarChart").getContext("2d");

        const maxYValue = data.maxGstAmount * 1.2; // Increase by 20% for better visibility

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels,
                datasets: data.datasets
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        }
                    },
                    y: {
                        stacked: false,
                        min: 0,
                        max: maxYValue,
                        ticks: {
                            callback: function(value) {
                                return "₹" + number_format(value);
                            }
                        },
                        grid: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: "rgb(255,255,255)",
                        titleColor: "#6e707e",
                        bodyColor: "#858796",
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.parsed.y;
                                return label + ": ₹" + number_format(value);
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
        
        
        
    });



