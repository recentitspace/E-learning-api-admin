"use strict";
$(function () {
    $(document).on("click", ".add-education", function () {
        let key = $(".education-area").data("length");
        key++;

        $(".education-area").append(`
             <div class="card education-card relative">
                <div class="grow grid grid-cols-2 gap-6 pt-10">
                    <div class="col-span-full md:col-auto relative">
                        <label class="form-label">${instituteName}</label>
                        <input type="text" placeholder="${enterText} ${instituteName}" name="educations[${key}][name]" id="searchInput" class="form-input search-suggestion"  data-search-type="university">
                         <div class="search-show"></div>
                    </div>
                    <div class="col-span-full md:col-auto">
                        <label class="form-label mb-2 d-block">${departmentName}</label>
                        <input type="text" placeholder="${enterText} ${departmentName}" name="educations[${key}][department]"  class="form-input">
                    </div>
                    <div class="col-span-full md:col-auto">
                        <label class="form-label">${degreeName}</label>
                        <input type="text" placeholder="${exampleText} : ${degreeNamePlaceholder}" name="educations[${key}][degree]"  class="form-input">
                    </div>
                    <div class="col-span-full md:col-auto">
                        <label class="form-label">GPA/CGPA</label>
                        <input type="text" placeholder="${enterText} GPA/CGPA" name="educations[${key}][cgpa]"  class="form-input">
                    </div>
                   
                    <div class="col-span-full md:col-auto">
                        <label class="form-label">${degreeDuration}</label>
                        <input type="text" placeholder="${enterText} ${degreeDuration}" name="educations[${key}][duration]" class="form-input" >
                    </div>
                    <div class="col-span-full md:col-auto">
                        <label class="form-label">${passingYear}</label>
                        <select class="singleSelect" name="educations[${key}][passing_year]">
                            <option selected disabled>${selectPassingYear}</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn b-solid btn-danger-solid h-max shrink-0 delete-btn dk-theme-card-square absolute top-6 right-6">
                    ${removeText}
                </button>
            </div>
             `);
        $(".education-area").data("length", key);

        $(".singleSelect").select2({
            width: "100%",
        });
    });

    $(document).on("click", ".add-experience", function () {
        let index = $(".experience-area").data("length");
        index++;
        $(".experience-area").append(
            `<div class="card experience-card relative">
                <div class="grow grid grid-cols-2 gap-6 pt-10">
                    <div class="col-span-full lg:col-auto leading-none relative">
                        <label class="form-label">${companyName}</label>
                        <input type="text" 
                         id="searchInput" 
                         placeholder="${enterText} ${companyName}" 
                         class="form-input search-suggestion" 
                         data-search-type="company" autocomplete="off"  
                         name="experiences[${index}][name]">
                        <div class="search-show"></div>
                    </div>
                    <div class="col-span-full lg:col-auto leading-none">
                        <label for="designation" class="form-label">${designationText}</label>
                        <input type="text" id="designation" placeholder="${enterText} ${designationText}"
                            class="form-input" autocomplete="off" 
                            name="experiences[${index}][designation]">
                    </div>
                    <div class="col-span-full lg:col-auto leading-none">
                        <label for="start-date" class="form-label">${startDate}</label>
                        <input type="date" id="start-date" placeholder="${startDate}"
                            class="form-input" autocomplete="off"
                            name="experiences[${index}][start_date]">
                    </div>
                    <div class="col-span-full lg:col-auto leading-none">
                        <div class="flex items-center gap-2">
                            <div class="grow">
                                <label for="end-date" class="form-label">${endDate}</label>
                                <input type="date" id="end-date" placeholder="${endDate}" class="form-input" autocomplete="off" name="experiences[${index}][end_date]">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full lg:col-auto leading-none">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="experiences[${index}][is_present]" id="current${index}" class="check check-primary-solid continue-working">
                            <label for="current${index}" class="form-label m-0">${continuingText}</label>
                        </div>
                    </div>
                </div>
                <button type="button"
                    class="btn b-solid btn-danger-solid h-max shrink-0 dk-theme-card-square  delete-btn absolute top-6 right-6">
                    ${removeText}
                </button>
            </div>
        `
        );
        $(".experience-area").data("length", index);
    });

    $(document).on("click", ".delete-btn", function () {
        let self = $(this);
        $(this).parent().remove();

        if (self.data("action")) {
            let action = $(self).data("action");
            $.ajax({
                url: action,
                method: "GET",
                dataType: "json",
            });
        }
    });
    var tags = $(".tm-input").tagsManager({});

    $(".typeahead").typeahead({
        name: "tags",
        displayKey: "name",
        source: function (query, process) {
            $.ajax({
                url: baseUrl + "/searching-suggestion",
                method: "GET",
                data: { search_type: "skill", key: query },
                success: function (data) {
                    return process(data);
                },
            });
        },
        afterSelect: function (item) {
            tags.tagsManager("pushTag", item.name);
        },
    });

    $(document).on("click", ".skill-remove", function (e) {
        e.preventDefault();
        let self = $(this);
        let id = self.data("id");
        let action = baseUrl + "/skill-remove/" + id;
        $.ajax({
            url: action,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    $("#exitingSkills").val(data.skills);
                    self.parent().remove();
                    if (data.hasOwnProperty("message")) {
                        Command: toastr["error"](`${data.message}`);
                    }
                }
            },
        });
    });
});
