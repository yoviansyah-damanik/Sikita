<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            margin: 1cm;
        }

        h1 {
            font-size: 12pt;
            font-weight: 700;
        }

        div {
            display: block;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .font-light {
            font-weight: 300;
        }

        .font-semibold {
            font-weight: 500;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-bolder {
            font-weight: bolder;
        }

        .font-lighter {
            font-weight: lighter;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        table {
            display: table;
            border-spacing: 2px;
            width: 100%;
            text-indent: 0;
            unicode-bidi: isolate;
        }

        table thead {
            vertical-align: middle;
        }

        table tr {
            display: table-row;
            vertical-align: inherit;
            unicode-bidi: isolate;
        }

        table th,
        table td {
            display: table-cell;
            vertical-align: inherit;
            unicode-bidi: isolate;
        }

        table.bordered {
            margin-top: 1rem;
            border-collapse: collapse;
        }

        table.bordered th {
            text-align: center;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid #ddd;
            padding: 6px;
        }

        table.bordered th {
            padding: 6px;
            background-color: #27647d;
            color: #fff;
        }

        table.bordered td {
            vertical-align: top;
        }

        .page-break {
            page-break-after: always;
        }

        .page-break-inside-avoid {
            page-break-inside: avoid;
        }

        .logo {
            position: relative;
            width: 80px;
        }

        .valign-middle {
            vertical-align: middle !important;
        }

        .underline {
            text-decoration: underline;
        }

        .text-xs {
            font-size: .75em;
        }

        .text-sm {
            font-size: .875em;
        }

        .uppercase {
            text-transform: uppercase
        }

        .italic {
            font-style: italic;
        }

        .p-4 {
            padding: 1rem;
        }

        .border {
            border: 1px solid #ddd;
        }

        .pb-3 {
            padding-bottom: .75rem;
        }

        .mt-3 {
            margin-top: .75rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-5 {
            margin-top: 1.25rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mt-9 {
            margin-top: 2.25rem;
        }

        .mb-3 {
            margin-bottom: .75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-5 {
            margin-bottom: 1.25rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-9 {
            margin-bottom: 2.25rem;
        }

        .mb-12 {
            margin-bottom: 3rem;
        }

        .mb-16 {
            margin-bottom: 4rem;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-s-0 {
            border-left-width: 0 !important;
        }

        .border-e-0 {
            border-right-width: 0 !important;
        }

        .w-44 {
            width: 11rem;
        }

        .w-1\/5 {
            width: calc(100% / 5);
        }

        .w-2\/5 {
            width: calc(100% * 2 / 5);
        }

        .w-3\/5 {
            width: calc(100% * 3 / 5);
        }

        .w-4\/5 {
            width: calc(100% * 4 / 5);
        }

        .w-1\/2 {
            width: 50%;
        }

        .w-1\/3 {
            width: 33.33%;
        }

        .w-2\/3 {
            width: 66.66%;
        }

        .w-full {
            width: 100%;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }
    </style>
</head>

<body>
    <h1 class="text-center uppercase mb-9">
        {{ __('Guidance Completion Mark') }}
    </h1>

    <div class="mb-9">
        <div style="clear:both;">
            <div style="width:20%; float:left">
                {{ __('Name') }}
            </div>
            <div style="width:40%; float:left">: {{ $student['data']['name'] }}</div>
            <div style="width:20%; float:left;">
                {{ __('Department') }}
            </div>
            <div style="width:20%; float:left">: Ilmu Komputer</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left;; float:left">
                {{ __('NIDN') }}
            </div>
            <div style="width:40%; float:left">: {{ $student['data']['npm'] }}</div>
            <div style="width:20%; float:left;">
                {{ __('Education Program') }}
            </div>
            <div style="width:20%; float:left">: Strata-I</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left">
                {{ __('Semester') }}
            </div>
            <div style="width:30%; float:left">: {{ $student['data']['semester'] }}</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left">
                {{ __('Stamp') }}
            </div>
            <div style="width:30%; float:left">: {{ $student['data']['stamp'] }}</div>
        </div>
    </div>

    <table class="bordered">
        <thead>
            <th>#</th>
            <th>{{ __('Guidance Group') }}</th>
            <th>#</th>
            <th>{{ __('Guidance Type') }}</th>
            <th>{{ __('Status') }}</th>
        </thead>
        <tbody>
            @foreach ($student['final_project']['guidances'] as $idx => $guidance)
                <tr>
                    <td class="text-center"
                        rowspan="{{ count($guidance['types']) > 0 ? count($guidance['types']) + 1 : 2 }}">
                        {{ $idx + 1 }}
                    </td>
                    <td rowspan="{{ count($guidance['types']) > 0 ? count($guidance['types']) + 1 : 2 }}">
                        {{ $guidance['name'] }}
                    </td>
                    @if (count($guidance['types']) > 0)
                        <td class="text-center">
                            {{ $idx + 1 . '.1' }}
                        </td>
                        <td>
                            {{ $guidance['types'][0]['name'] }}
                        </td>
                        <td class="text-center">
                            {{ $guidance['types'][0]['is_reviewed'] ? __('Finish') : __('Not Finished Yet') }}
                        </td>
                    @else
                        <td colspan=3 class="text-center">
                            {{ __('No data found') }}
                        </td>
                    @endif
                </tr>
                @if (count($guidance['types']) > 1)
                    @foreach (collect($guidance['types'])->skip(1) as $idx_ => $type)
                        <tr>
                            <td class="text-center">
                                {{ $idx + 1 . '.' . $idx_ + 1 }}
                            </td>
                            <td>
                                {{ $type['name'] }}
                            </td>
                            <td class="text-center">
                                {{ $type['is_reviewed'] ? __('Finish') : __('Not Finished Yet') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan=3>
                        {{ __(':status Status', ['status' => __('Overall')]) }}:
                        <strong>
                            {{ $guidance['is_finish'] ? __('Finish') : __('Not Finished Yet') }}
                        </strong>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5">
                    <div class="flex items-center justify-between">
                        <div>
                            {{ __(':status Status', ['status' => __('Overall')]) }}:
                            <strong>
                                {{ $student['is_finish'] ? __('Finish') : __('Not Finished Yet') }}
                            </strong>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break-inside-avoid mt-9" style='clear:both'>
        @if (count($student['supervisors']) > 0)
            <table>
                <tr>
                    @foreach ($student['supervisors'] as $supervisor)
                        <td style="width: 50%">
                            <div class="mb-16 font-bold text-center">
                                {{ __('Supervisor :1', ['1' => Str::substr($supervisor['as'], -1)]) }}
                            </div>
                            <div class="font-bold text-center">
                                {{ $supervisor['name'] }}
                            </div>
                            <div class="font-light text-center">
                                NIDN. {{ $supervisor['nidn'] }}
                            </div>
                        </td>
                    @endforeach
                </tr>
            </table>
        @endif
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 30;
            $x_2 = 540;
            $x_3 = 450;

            $y = 815;
            $text = "Diakses melalui {{ url('/') }} | {{ env('APP_NAME') }} | {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}";
            $text_2 = "{PAGE_NUM} / {PAGE_COUNT}";
            $font = $fontMetrics->get_font("sans-serif");
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            $pdf->page_text($x_2, $y, $text_2, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>

</html>
