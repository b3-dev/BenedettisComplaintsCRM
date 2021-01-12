@extends('esqueleton.header')
@section('middleSection')

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3> P{{$data['PERIOD_PA']}} Por tipo </h3>
    </div>
    <div class="card-body">
        <!--datatable -->
        <?php
        $totalCountPP = 0;
        $totalPercentPP = 0;
        $totalCountPA = 0;
        $totalPercentPA = 0;
        $totalVariance = 0;

        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th colspan="2" scope="col">PP({{ $data['PERIOD_PP'] }})</th>
                    <th colspan="2" scope="col">PA({{ $data['PERIOD_PA'] }})</th>
                    <th scope="col">Var</th>
                </tr>
                <tr>
                    <th scope="col">Tipo</th>
                    <th scope="col">#</th>
                    <th scope="col">%</th>
                    <th scope="col">#</th>
                    <th scope="col">%</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($data['arrayPerType']))

                @foreach($data['arrayPerType'] as $rowPerType)
                <tr>
                    <th scope="row">{{$rowPerType['CATEGORY_DESCRIPTION']}}</th>
                    <td>{{$rowPerType['COUNT_PP']}}</td>
                    <td>{{$rowPerType['PERCENT_PP']}}</td>
                    <td>{{$rowPerType['COUNT_PA']}}</td>
                    <td>{{$rowPerType['PERCENT_PA']}}</td>
                    <td>{{$rowPerType['VARIANCE']}}</td>

                </tr>

                <?php
                $totalCountPP += $rowPerType['COUNT_PP'];
                $totalPercentPP += $rowPerType['PERCENT_PP'];
                $totalCountPA += $rowPerType['COUNT_PA'];
                $totalPercentPA += $rowPerType['PERCENT_PA'];
                $totalVariance += $rowPerType['VARIANCE'];
                ?>
                @endforeach
                @else
                <tr>
                    <h7>No se localizaron datos para desplegar</h7>
                </tr>
                @endif

            </tbody>
            <tfoot>
                <tr>
                    <th scope="row">Totales</th>
                    <td>{{$totalCountPP}}</td>
                    <td>{{$totalPercentPP}}</td>
                    <td>{{$totalCountPA}}</td>
                    <td>{{$totalPercentPA}}</td>
                    <td>{{$totalVariance}}</td>
                </tr>
            </tfoot>
        </table>

        <!--enddatatable-->
    </div>
</div>
@endsection
