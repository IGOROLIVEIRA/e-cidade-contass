class DateFormatter {
    public static function formatDateToDmy(string $date): string {
        $dateObj = DateTime::createFromFormat('d/m/Y', $date);

        if ($dateObj === false) {
            throw new Exception("Please, provide an string with d/m/Y formmat.");
        }

        return $dateObj->format('d/m/Y');
    }
}
