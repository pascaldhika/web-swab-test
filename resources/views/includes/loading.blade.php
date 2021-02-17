<div id="theLoading">
    <div class="il">
        <div class="il2">
            <div class="il3">
                <img src="{{url('adminlte/img/spinner-200px.gif')}}" alt="Loading..." /><br />
                <span>Please wait</span>
            </div>
        </div>
    </div>
</div>
<style>
    #theLoading {
        background-color: rgba(0, 0, 0, 0.4);
        position: fixed;
        z-index: 99999;
        display: none;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    #theLoading .il {
        display: table;
        height: 100%;
        width: 100%;
    }
    #theLoading .il2 {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }
    #theLoading .il3 {
        color: rgb(50, 50, 50);
        background-color: #fff;
        display: inline-block;
        padding: 10px 15px;
        border-radius: 5px;
    }
    #theLoading .il3 img {
        display: inline-block;
        width: 100px;
    }
    #theLoading .il3 span {
        display: inline-block;
        padding: 0 5px 15px;
    }
</style>
<script>
    var __theLoading,
        showLoading;
    $(document).ready(function () {
        __theLoading = $("#theLoading", document);
        showLoading = (type, cb) => {
            if (typeof type == "undefined") type = !__theLoading.is(":visible");
            if (type) {
                __theLoading.fadeIn(150, () => {
                    if (typeof cb == "function") cb();
                });
            } else {
                __theLoading.fadeOut(150, () => {
                    if (typeof cb == "function") cb();
                });
            }
        };
    });
</script>
