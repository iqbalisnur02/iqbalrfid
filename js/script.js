$(document).ready(function(){


    //real time halaman tambahmodal.php
        setInterval(function() {
                $('.idmasuk').load('idmasuk.php');
                        }, 100);

    //real time halaman kehadiran-value.php
        setInterval(function() {
                $('.kehadiran-value').load('kehadiran-value.php');
                        }, 100);

    //real time halaman dataakses-value.php
        setInterval(function() {
                $('.dataakses-value').load('dataakses-value.php');
                        }, 100);

		//real time halaman dashboard.php
				setInterval(function() {
            		$('.dashboard-value').load('dashboard-value.php');
          							}, 100);

		//sweet alert hapus data 
          $('.alert_hapus').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin menghapus data ini?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }

            });
                
            });

          //sweet alert logout 
          $('.alert_logout').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin logout?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }
            });
            });          


  });