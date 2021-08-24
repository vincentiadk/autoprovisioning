<div id="myContent">
    <style>
.steps {
    position: relative;
}

/*progressbar*/
#progressbar {
    overflow: hidden;
    /*CSS counters to number the steps*/
    counter-reset: step;
    width: 100%;
    text-align: center;
}

#progressbar li {
    list-style-type: none;
    color: rgb(51, 51, 51);
    text-transform: uppercase;
    font-size: 1em;
    width: 20%;
    float: left;
    position: relative;
}

#progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 20px;
    line-height: 20px;
    display: block;
    font-size: 1em;
    color: #333;
    background: white;
    border-radius: 3px;
    margin: 0 auto 5px auto;
}

/*progressbar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: white;
    position: absolute;
    left: -50%;
    top: 9px;
    z-index: -1;
    /*put it behind the numbers*/
}

#progressbar li:first-child:after {
    /*connector not needed before the first step*/
    content: none;
}

/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,
#progressbar li.active:after {
    background: #7B1FA2;
    color: white;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="container-fluid dashboard-content">
    <!-- Main content -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $data['title'] }} </h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="page" href="{{ url('panel/dashboard') }}"
                                    class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a class="page" href="{{ url('panel/configuration') }}"
                                    class="breadcrumb-link">Konfigurasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="steps">
        <ul id="progressbar">
            <li><a href="#" id="aOrder">Order Review</a></li>
            <li><a href="#" id="aMetro">Metro</a> </li>
            <li><a href="#" id="aGpon">GPON</a></li>
            <li><a href="#" id="aOnt">ONT</a></li>
            <li><a href="#" id="aReview">Review</a></li>
        </ul>
    </div>
    <div class="row">
        <form id="form_data" class="col-md-12">
            <input type="hidden" id="config_id" value="{{ $data['config_id'] }}" name="config_id">
            <div id="formConfig" class="card">
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-md btn-primary" id="btn_prev" onclick="prevFrom()">Prev</button>
                <button type="button" class="btn btn-md btn-info" id="btn_simpan" onclick="simpan()">Save</button>
                <button type="button" class="btn btn-md btn-primary" id="btn_next" onclick="nextForm()">Next</button>
            </div>
        </form>
    </div>
</div>
<script>
var currentForm = 0,
    aLink = [{
            'idx': 0,
            'id': 'aOrder',
            'page': 'panel/configuration/config-order'
        },
        {
            'idx': 1,
            'id': 'aMetro',
            'page': 'panel/configuration/config-metro'
        },
        {
            'idx': 2,
            'id': 'aGpon',
            'page': 'panel/configuration/config-gpon'
        },
        {
            'idx': 3,
            'id': 'aOnt',
            'page': 'panel/configuration/config-ont'
        },
        {
            'idx': 4,
            'id': 'aReview',
            'page': 'panel/configuration/config-review'
        }
    ],
    activeLink = getSearchParams('aLink'),
    pageGpon = getSearchParams('pagegpon'),
    aPage = "";
if (activeLink == undefined) {
    activeLink = 'aOrder';
    aPage = 'panel/configuration/config-order';
    $('#btn_prev').hide();
} else {
    $.each(aLink, function() {
        if (this.id === activeLink) {
            aPage = this.page;
            currentForm = this.idx;
        }
    });
    $('#btn_prev').show();
}

loadForm(aPage, activeLink);
$('a').on('click', function() {
    event.prefentDefault();
})
$(document).pjax('.page-gpon', '#formConfig');
function loadForm(page, id, next = false) {
    $.ajax({
        url: "{{ url('auth/check-login') }}",
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function(jqXHR) {
            //    loadingOpen('#formConfig');
        },
        success: function(response) {
            params = page + "?config_id=" + $('#config_id').val();
            if(pageGpon !== undefined) {
                params += "&pagegpon=" + pageGpon;
            }
            if (response) {
                $("#formConfig").load("{{url('')}}" + "/" + params);
            } else {
                location.href = "{{ url('login') }}";
            }

            $('#' + activeLink).parent().removeClass("active");
            activeLink = id;
            $('#' + id).parent().addClass("active");
            //    loadingClose('#formConfig');
        }
    });
}



function nextForm() {
    currentForm++;
    if (currentForm == 4) {
        $('#btn_next').hide();
        $('#btn_simpan').text('Finish');
    } else if (currentForm > 0) {
        $('#btn_simpan').text('Simpan');
        $('#btn_next').show();
    }
    loadForm(aLink[currentForm].page, aLink[currentForm].id, true);
    $('#btn_prev').show();
}

function prevFrom() {
    currentForm--;
    if (currentForm == 0) {
        $('#btn_prev').hide();
    } else {
        $('#btn_prev').show();
    }
    $('#btn_simpan').text('Simpan');
    loadForm(aLink[currentForm].page, aLink[currentForm].id, true);
    $('#btn_next').show();
}
</script>
<div>>