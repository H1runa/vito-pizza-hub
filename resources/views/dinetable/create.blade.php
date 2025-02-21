<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Table</title>
</head>
<body>
    <h3>Add Table</h3>
    <form action="{{route('dinetable.store')}}" method="POST">
        @csrf
        <table>
            <tr>
                <td><label>Number of Seats : </label></td>
                <td><input type="number" name="seats" id="seats"><br></td>
            </tr>
            <tr>
                <td><label>Availability: </label></td>
                <td>
                    <select name="ava" id="ava">
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select>
                </td>
            </tr>
        </table>                                
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>