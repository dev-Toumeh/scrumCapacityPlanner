<?php
declare(strict_types=1);

namespace Form;

use Laminas\Form\View\Helper\AbstractHelper;

class InfoForm extends AbstractHelper
{
    public function getThead(): string
    {
        return '
        <tr>
            <th scope="col">#</th> 
            <th scope="col">Full Name</th>
            <th scope="col">SP</th>
            <th scope="col">Summe</th>
            <th scope="col">D/SPR</th>
            <th scope="col">PFAK</th>
            <th scope="col">Factor</th>
            <th scope="col">StoryPoints Last 25 Weeks</th>
            <th scope="col">Absence Days</th>
            <th scope="col">Wochen</th>
            <th scope="col">ticket without story points</th>
        </tr>
    ';
    }

    public function getTbody($key, $devCap): string
    {
        return
            '<tr>
        <th scope="row">' . $key . '</th>
        <td>' . $devCap['fullName'] . '</td>
        <td>' . $devCap['SP'] . '</td>
        <td>     &nbsp;         </td>
        <td>' . $devCap['D/SPR'] . '</td>
        <td>' . $devCap['PFAK'] . '&nbsp; %</td>
        <td>' . $devCap['Factor'] . '</td>
        <td>' . $devCap['SPLast25weeks'] . '</td>
        <td>' . $devCap['AbsenceDays'] . '</td>
        <td>' . $devCap['Wochen'] . '</td>
        <td>' . $devCap['WithoutSP'] . '</td>
    </tr>';

    }

    public function getSumTr($sum): string
    {
        return
            '<tr>
        <th scope="row"></th>
        <td></td>
        <td></td>
        <td>' . $sum . '</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>';
    }

}

































