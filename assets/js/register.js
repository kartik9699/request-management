document.addEventListener("DOMContentLoaded", function () {
    // Get all user type sections
    let CH = document.getElementById("CH");
    let ZH = document.getElementById("ZH");
    let SH = document.getElementById("SH");  // Fixed typo (was "CH")
    let TM = document.getElementById("TM");
    let SE = document.getElementById("SE");  // Added SE section
    let user = document.getElementById("user_type");
    
    // Initially hide all sections
    CH.style.display = "none";
    ZH.style.display = "none";
    SH.style.display = "none";
    TM.style.display = "none";
     // Hide SE if it exists

    user.addEventListener("change", function () {
        // First hide all sections
        CH.style.display = "none";
        ZH.style.display = "none";
        SH.style.display = "none";
        TM.style.display = "none";
        
        
        // Then show only the selected one
        switch(this.value) {
            case "CH":
                
                SH.style.display = "block";
                break;
            case "SH":
                ZH.style.display = "block";
                break;
            case "TM":
                CH.style.display = "block";
                break;
            case "SE":
                TM.style.display = "block";
                break;
            default:
                // Hide all if no selection or invalid selection
                CH.style.display = "none";
                ZH.style.display = "none";
                SH.style.display = "none";
                TM.style.display = "none";
        }
    });
});