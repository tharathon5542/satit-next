<!-- load pre loader component -->
<?php $this->load->view('z_template/components/preloaderComp'); ?>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/topbarComp'); ?>

    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/leftbarComp'); ?>

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <!-- load bread crumb component -->
            <?php $this->load->view('z_template/components/breadCrumbComp', isset($page) ? $page : ''); ?>

            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="d-flex no-block align-items-center mb-4">
                <h4>ข่าวประชาสัมพันธ์ </h4>
                <button class="btn btn-success text-white ms-auto" onclick="openAddModal()">เพิ่มข่าวประชาสัมพันธ์</button>
            </div>
            <div class="row animated bounceInRight">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input id="searchInput" type="text" class="form-control" placeholder="ป้อนคำค้นหา : หัวข้อข่าว">
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- news container -->
            <!-- ============================================================== -->
            <div class="d-flex no-block justify-content-center">
                <h4 id="searchNotFound" class="text-muted" hidden>Data Not Found!</h4>
            </div>

            <div id="newsContainer"></div>

            <div id="paginationContainer" class="mb-4"></div>
        </div>

    </div>
    <!-- load foot component -->
    <?php $this->load->view('z_template/components/footComp'); ?>
</div>

<!-- modal container -->
<div id="modal-container"></div>

<script>
    var currentPageGlobal = 1;

    window.onload = function() {
        var searchTimer;
        // Attach an input event listener to the search input box
        $("#searchInput").on("input", function() {
            // Clear the existing timer
            clearTimeout(searchTimer);

            // Get the search keyword
            var searchKeyword = $(this).val().trim();

            // Start a new timer to delay the search
            searchTimer = setTimeout(function() {
                searchNews(searchKeyword); // Call the fetchNews function with the search keyword
            }, 250); // Set a 500ms delay before performing the search
        });

        // ==========================================================
        fetchNews(currentPageGlobal);
        // ==========================================================
    };

    function fetchNews(currentPage, edit = false) {
        // get news
        $.ajax({
            url: "<?php echo base_url('crud/news/getNews') ?>",
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }

                // Number of items to display per page
                const itemsPerPage = 3;

                // Calculate the total number of pages
                const totalPages = Math.ceil(response.data.length / itemsPerPage);

                // Store the data in a variable accessible to pagination functions
                const allData = response.data;

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                // Display the initial page
                displayPage(currentPage, allData, itemsPerPage, edit);

                // Create pagination buttons
                createPaginationButtons(totalPages, currentPage, itemsPerPage, allData);

                Swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function searchNews(searchKeyword) {
        // get news
        $.ajax({
            url: "<?php echo base_url('crud/news/getNews') ?>",
            method: "POST",
            dataType: "json",
            data: {
                searchKeyword: searchKeyword
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }

                // Number of items to display per page
                const itemsPerPage = 3;

                // Calculate the total number of pages
                const totalPages = Math.ceil(response.data.length / itemsPerPage);

                // Store the data in a variable accessible to pagination functions
                searchedData = response.data;

                // Display the initial page
                displayPage(1, searchedData, itemsPerPage, false);

                // Create pagination buttons
                createPaginationButtons(totalPages, 1, itemsPerPage, searchedData);

                if (searchedData.length <= 0) {
                    $('#searchNotFound').removeAttr('hidden');
                } else {
                    $('#searchNotFound').attr('hidden', true);
                }

                Swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function displayPage(page, data, itemsPerPage, edit) {
        // Clear the container
        $("#newsContainer").empty();

        // Calculate the start and end indices of the items to display
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Slice the data array to get the items for the current page
        const pageData = data.slice(startIndex, endIndex);

        // Display the items for the current page
        $.each(pageData, function(index, value) {
            let addNewsCard = `
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <div id="carousel${value.newsID}" class="carousel slide" data-bs-ride="carousel">
                                        <ol id="indicatorsContainer${value.newsID}" class="carousel-indicators">
                                            <!-- --------------------------------------------------------------- -->
                                            <!-- --------------------------------------------------------------- -->
                                        </ol>
                                        <div id="carouselNewsImagesContainer${value.newsID}" class="carousel-inner" role="listbox">
                                            <!-- --------------------------------------------------------------- -->
                                            <!-- --------------------------------------------------------------- -->
                                        </div>
                                        <a class="carousel-control-prev" href="#carousel${value.newsID}" role="button" data-bs-slide="prev" data-bs-target="#carousel${value.newsID}">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel${value.newsID}" role="button" data-bs-slide="next" data-bs-target="#carousel${value.newsID}">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <div class="comment-text w-100">
                                        <h5>${value.newsTitle}</h5>
                                        <span class="text-muted">ข่าวลงเมื่อวันที่ : ${value.newsDateTH} เวลา : ${value.newsTime}</span> <br>
                                        <span class="text-muted">ข่าวลงโดย : ${value.newsAuthor}</span>
                                        <div class="card m-b-5 mt-4">
                                            <div class="card-header">
                                                เนื้อหาข่าว
                                                <div class="card-actions">
                                                    <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body collapse">
                                                <div class="m-b-5 m-t-10">
                                               ${value.newsDetail}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex no-block justify-content-end">
                                        <button class="btn btn-info text-white me-2" onclick="openEditModal(${value.newsID})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger text-white" onclick="onDelete(${value.newsID})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

            $('#newsContainer').append(addNewsCard);

            $("#indicatorsContainer" + value.newsID).empty();
            $("#carouselNewsImagesContainer" + value.newsID).empty();

            if (value.newsImages.length > 0) {
                $.each(value.newsImages, function(newsImageIndex, newsImage) {
                    let indicator = `<li data-bs-target="#carousel${value.newsID}" data-bs-slide-to="${newsImageIndex}" class="${newsImageIndex == 0 ? 'active' : ''}"></li>`;

                    $("#indicatorsContainer" + value.newsID).append(indicator);

                    let carouselNewsImage = `
                            <div class="carousel-item ${newsImageIndex == 0 ? 'active' : ''}">
                                <div class="el-element-overlay">
                                    <div class="el-card-item ">
                                        <div class="el-card-avatar el-overlay-1 ">
                                            <img class="img-fluid" style="height: 300px; object-fit: contain;" src="<?php echo base_url('assets/images/newsImages/') ?>${newsImage.newsImageName + newsImage.newsImageType}" alt="add news image" />
                                            <div class="el-overlay">
                                            <ul class="el-info">
                                                <li>
                                                    <button class="btn default btn-outline" onclick="openAddImageModal(${value.newsID})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </li>
                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?php echo base_url('assets/images/newsImages/') ?>${newsImage.newsImageName + newsImage.newsImageType}"><i class="icon-magnifier"></i></a></li>
                                                <li>
                                                    <button class="btn default btn-outline" onclick="onDeleteNewsImage(${newsImage.newsImageID})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        `;
                    $('#carouselNewsImagesContainer' + value.newsID).append(carouselNewsImage);
                });
            } else {
                let Lastindicator = `
                                <li data-bs-target="#carousel${value.newsID}" data-bs-slide-to="0" class="active"></li>
                            `;
                $("#indicatorsContainer" + value.newID).append(Lastindicator);
                let lastCarouselNewsImage = `
                                            <div class="carousel-item active">
                                                <div class="el-element-overlay">
                                                    <div class="el-card-item ">
                                                        <div class="el-card-avatar el-overlay-1 ">
                                                            <img class="img-fluid" src="<?php echo base_url('assets/images/background/image-holder.png') ?>" alt="add news image" />
                                                            <div class="el-overlay">
                                                                <ul class="el-info">
                                                                    <li>
                                                                        <button class="btn default btn-outline" onclick="openAddImageModal(${value.newsID})">
                                                                            <i class="fas fa-plus"></i>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            `;
                $('#carouselNewsImagesContainer' + value.newsID).append(lastCarouselNewsImage);
            }
        });

        if (!edit) {
            // adjust this value to control the delay between animations
            let delayFactor = 0.2;
            // animation after add
            $('#newsContainer > *').each(function(index) {
                $(this).addClass('animated bounceInRight').css('animation-delay', (index + 1) * delayFactor + 's').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    $(this).removeClass('animated bounceInRight').css('animation-delay', '');
                });
            });
        }

        // Initialize magnificPopup
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile mfp-fade',
            image: {
                verticalFit: true
            },
        });

        // Initialize all collapse buttons
        $('[data-action="collapse"]').click(function(e) {
            e.preventDefault();
            $(this).closest('.card').find('.collapse').collapse('toggle');
            $(this).find('i').toggleClass('ti-minus');
        });
    }

    function createPaginationButtons(totalPages, currentPage, itemsPerPage, allData) {
        // Clear the pagination container
        $("#paginationContainer").empty();

        if (allData.length <= 0) {
            return;
        }

        // Create the previous button
        var prevButton = $("<button>").text("Previous").addClass("btn btn-info text-white pagination-btn me-1");
        if (currentPage === 1) {
            prevButton.prop("disabled", true);
        } else {
            prevButton.click(function() {
                var page = currentPage - 1;
                displayPage(page, allData, itemsPerPage);

                // Update the current page
                currentPageGlobal = page;
                // Re-create the pagination buttons
                createPaginationButtons(totalPages, currentPageGlobal, itemsPerPage, allData);
            });
        }
        $("#paginationContainer").append(prevButton);

        // Create a button for each page
        for (var i = 1; i <= totalPages; i++) {
            var button = $("<button>").text(i).addClass("btn btn-info text-white pagination-btn me-1");

            // Add active class to the current page button
            if (i === currentPage) {
                button.prop("disabled", true);
            }

            // Attach a click event handler to each button
            button.click(function() {
                var page = parseInt($(this).text());
                displayPage(page, allData, itemsPerPage);

                // Update the current page
                currentPageGlobal = page;
                // Re-create the pagination buttons
                createPaginationButtons(totalPages, currentPageGlobal, itemsPerPage, allData);
            });

            // Append the button to the pagination container
            $("#paginationContainer").append(button);
        }

        // Create the next button
        var nextButton = $("<button>").text("Next").addClass("btn btn-info text-white pagination-btn");
        if (currentPage === totalPages) {
            nextButton.prop("disabled", true);
        } else {
            nextButton.click(function() {
                var page = currentPage + 1;
                displayPage(page, allData, itemsPerPage);

                // Update the current page
                currentPageGlobal = page;
                // Re-create the pagination buttons
                createPaginationButtons(totalPages, currentPageGlobal, itemsPerPage, allData);
            });
        }

        $("#paginationContainer").append(nextButton);
    }

    function openAddModal() {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/news/addModal') ?>",
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);
                // Show the modal
                $("#newsAddModal").modal("show");

            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function openEditModal(newsID) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/news/editModal/') ?>" + newsID,
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }

                // Insert modal content into the page
                $("#modal-container").html(response.data);

                // set variable
                $('#newsID').val(response.newsResponse.newsID);
                $('#newsUrl').val(response.newsResponse.newsURL);
                $('#newsTitle').val(response.newsResponse.newsTitle);
                $('#newsDetail').val(response.newsResponse.newsDetail);

                // Show the modal
                $("#newsEditModal").modal("show");

            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function openAddImageModal(newsID) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/news/addImageModal/') ?>" + newsID,
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                // set variable
                $('#newsID').val(response.newsID);

                // Show the modal
                $("#newsImageAddModal").modal("show");
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function onDelete(newID) {
        // Display a SweetAlert confirmation dialog
        Swal.fire({
            title: 'ยืนยันการลบ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ย้อนกลับ',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url('crud/news/onDeleteNews/') ?>' + newID,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลแล้ว", 1500);
                        setTimeout(function() {
                            fetchNews(currentPageGlobal);
                        }, 1500)
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        })
    }

    function onDeleteNewsImage(newID) {
        // Display a SweetAlert confirmation dialog
        Swal.fire({
            title: 'ยืนยันการลบ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ย้อนกลับ',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url('crud/news/onDeleteNewsImage/') ?>' + newID,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลแล้ว", 1500);
                        setTimeout(function() {
                            fetchNews(currentPageGlobal, true);
                        }, 1500)
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        })
    }
</script>