<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRut implements Rule
{
    public function passes($attribute, $value)
    {
        $rutNumerico = preg_replace('/[^0-9]/', '', $value);

        $rutSinDigitoVerificador = substr($rutNumerico, 0, -1);

        if (strlen($rutSinDigitoVerificador) < 7 || strlen($rutSinDigitoVerificador) > 8) {
            return false;
        }

        $rutInvertido = strrev($rutSinDigitoVerificador);

        $multiplicadores = [2, 3, 4, 5, 6, 7, 2, 3];

        $suma = 0;
        $index = 0;

        for ($i = 0; $i < strlen($rutInvertido); $i++) {
            $suma += intval($rutInvertido[$i]) * $multiplicadores[$index];
            $index++;
            if ($index >= count($multiplicadores)) {
                $index = 0;
            }
        }

        $resto = $suma % 11;
        $digitoVerificador = 11 - $resto;

        if ($digitoVerificador === 11) {
            $digitoVerificador = 0;
        }

        return $digitoVerificador == substr($value, -1);
    }

    public function message()
    {
        return 'El :attribute ingresado no es un RUT chileno válido.';
    }
}
