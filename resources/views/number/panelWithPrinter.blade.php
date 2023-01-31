@extends('layouts.panelWithPrinter')

@section('content')
<table class="panel"
    style="text-align: center; margin-top:10vh; !important;width: 100%; margin-left: auto; margin-right: auto;"
    border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td></td>
            <td rowspan="0" class="colunaDados">
                <table style="text-align: center; width: 100%; margin-left: auto; margin-right: auto; height: 100%;"
                    cellspacing="10">
                    <tbody>
                        <tr>
                            <td>
                                <div class="nameNumber" id="nameNumber">SENHA</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="stringNumber" id="stringNumber">000</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="backgroundGreen">
                                <div class="nameQueue" id="nameQueue">-</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="nameNumber" id="nameTable">GUICHÊ</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="stringTable" id="table-number">00</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="stringDate" class="stringDate">00/00/0000</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="stringTime" class="stringTime">00:00:00</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td class="video">
                <div>
                    <video width="95%" height="40%" autoplay loop muted>
                        <source src="{{ url('/videos/video.mp4') }}" type="video/mp4" />
                    </video>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="print">
    <div style="line-height: 0.010;">
        <div style="text-align: center; line-height: 0.010;">
            <img src="{{ url('images/logo.png') }}" alt="Logo Sicoob" style="max-height: 100px; max-width:150px;">
            <hr>
            <h4 id="queue" style="max-height: 2px">-</h4>
            <h1 id="number" style="max-height: 2px">-</h1>
            <hr>
            <h6 id="date" style="max-height: 2px">-</h4>
        </div>
    </div>

</div>
@stop
