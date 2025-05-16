document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const verticalNavbar = document.getElementById('verticalNavbar');
    const menuIcon = document.getElementById('menuIcon');
    
    // Toggle mobile menu
    mobileMenuBtn.addEventListener('click', function() {
        verticalNavbar.classList.toggle('active');
        
        // Toggle between hamburger and close icon
        if (verticalNavbar.classList.contains('active')) {
            menuIcon.classList.replace('fa-bars', 'fa-times');
            document.body.style.overflow = 'hidden';
        } else {
            menuIcon.classList.replace('fa-times', 'fa-bars');
            document.body.style.overflow = '';
        }
    });
    
    // Close menu when a link is clicked (mobile only)
    document.querySelectorAll('.vertical-navbar a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                verticalNavbar.classList.remove('active');
                menuIcon.classList.replace('fa-times', 'fa-bars');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close menu when window is resized above 768px
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            verticalNavbar.classList.remove('active');
            menuIcon.classList.replace('fa-times', 'fa-bars');
            document.body.style.overflow = '';
        }
    });
});
function openAllowModal() {
    document.getElementById('allowModal').style.display = 'flex';
}

function closeAllowModal() {
    document.getElementById('allowModal').style.display = 'none';
}

function openDisallowModal() {
    document.getElementById('disallowModal').style.display = 'flex';
}

function closeDisallowModal() {
    document.getElementById('disallowModal').style.display = 'none';
}

// Action Functions
function submitApproval() {
    const notes = document.getElementById('approvalNotes').value;
    alert(`Order approved with notes: ${notes}`);
    closeAllowModal();
    // Add your actual approval logic here
}

function confirmRejection() {
    alert('Order has been rejected');
    closeDisallowModal();
    // Add your actual rejection logic here
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'custom-modal') {
        event.target.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const dateRangeSelect = document.getElementById('dateRange');
    const dateGroups = document.querySelectorAll('.date-group');
    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');
    const downloadBtn = document.getElementById('downloadReport');
    
    // Set default dates when page loads
    setDefaultDates('month');
    
    // Date range selector logic
    dateRangeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            // Show date inputs for custom range
            dateGroups.forEach(group => group.style.display = 'block');
        } else {
            // Hide date inputs for preset ranges
            dateGroups.forEach(group => group.style.display = 'none');
            // Set default dates for the selected range
            setDefaultDates(this.value);
        }
    });
    
    // Download Report functionality
    downloadBtn.addEventListener('click', function() {
        const reportType = document.getElementById('reportType').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const dateRange = dateRangeSelect.value;
        
        let fromDate, toDate;
        if (dateRange === 'custom') {
            fromDate = fromDateInput.value;
            toDate = toDateInput.value;
            
            // Validate custom dates
            if (!fromDate || !toDate) {
                alert('Please select both From and To dates for custom range');
                return;
            }
            
            if (new Date(fromDate) > new Date(toDate)) {
                alert('From date cannot be after To date');
                return;
            }
        } else {
            // Use the dates we set in setDefaultDates
            fromDate = fromDateInput.value;
            toDate = toDateInput.value;
        }
        
        // Generate and download report
        generateAndDownloadReport(reportType, fromDate, toDate, statusFilter);
    });
    
    // Function to set default dates based on range selection
    function setDefaultDates(range) {
        const today = new Date();
        let startDate = new Date();
        
        switch(range) {
            case 'today':
                break; // startDate is already today
            case 'week':
                startDate.setDate(today.getDate() - 7);
                break;
            case 'month':
                startDate.setMonth(today.getMonth() - 1);
                break;
            case 'quarter':
                startDate.setMonth(today.getMonth() - 3);
                break;
            case 'year':
                startDate.setFullYear(today.getFullYear() - 1);
                break;
            default:
                return;
        }
        
        // Format dates as YYYY-MM-DD for input fields
        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        
        // Set the hidden input values
        fromDateInput.value = formatDate(startDate);
        toDateInput.value = formatDate(today);
    }
    
    // Function to generate and download report
    function generateAndDownloadReport(type, from, to, status) {
        // In a real app, you would make an API call here
        console.log('Generating report:', {
            type: type || 'all',
            dateRange: `${from} to ${to}`,
            status: status || 'all'
        });
        
        // For demo purposes, we'll create a simple CSV
        const headers = ['Order ID', 'Date', 'Customer', 'Amount', 'Status', 'Dispatch Date'];
        const rows = [
            ['#ORD-2023-1001', '2023-10-05', 'John Smith', '$249.99', 'Completed', '2023-10-07'],
            ['#ORD-2023-1002', '2023-10-08', 'Sarah Johnson', '$149.50', 'Completed', '2023-10-10'],
            ['#ORD-2023-1003', '2023-10-12', 'Michael Brown', '$89.99', 'Pending', ''],
            ['#ORD-2023-1004', '2023-10-15', 'Emily Davis', '$199.99', 'Completed', '2023-10-17']
        ];
        
        // Filter rows based on status if specified
        const filteredRows = status 
            ? rows.filter(row => row[4].toLowerCase().includes(status.toLowerCase()))
            : rows;
        
        // Create CSV content
        const csvContent = [
            headers.join(','),
            ...filteredRows.map(row => row.join(','))
        ].join('\n');
        
        // Create download link
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', `report_${type || 'all'}_${from}_to_${to}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message
        alert(`Report downloaded successfully!\n\nType: ${type || 'All'}\nDate Range: ${from} to ${to}\nStatus: ${status || 'All'}`);
    }
});