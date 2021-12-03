<?php

$array_post = array (
    'form_logout' => "<form name=\"form\" method=\"post\" action=\"\">
                        <table>
                            <tr>
                                <td>Добро пожаловать: </td>
                                <td>" . $_COOKIE['name'] . "</td>
                                <td><input id=\"submit\" type=\"submit\" name=\"logout\" value=\"Выход\" /></td>
                            </tr>
                        </table>
                    </form>",
    'form_sugnin_login' => "<form name=\"form\" method=\"post\" action=\"\">
                <table>
                    <thead>
                        <tr>
                            <td><b>Выберите действие</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type=\"submit\" name=\"signup\" value=\"Регистрация\" /></td>
                        </tr>
                        <tr>
                            <td><input type=\"submit\" name=\"login\" value=\"Авторизация\" /></td>
                        </tr>           
                    </tbody>
                </table>
            </form>"
);

?>