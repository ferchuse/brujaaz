<?php
/* ASCII constants */
const ESC = "\x1b";
const GS="\x1d";
const NUL="\x00";

/* Output an example receipt */
echo ESC."@"; // Reset to defaults
echo ESC."E".chr(1); // Bold
echo "FOO CORP Ltd.\n"; // Company
echo ESC."E".chr(0); // Not Bold
echo ESC."d".chr(1); // Blank line
echo "Receipt for whatever\n"; // Print text
echo ESC."d".chr(4); // 4 Blank lines

/* Bar-code at the end */
echo ESC."a".chr(1); // Centered printing
// echo GS."k".chr(4)."987654321".NUL; // Print barcode
echo ESC."d".chr(1); // Blank line
echo "987654321\n"; // Print number
echo GS."V\x41".chr(3); // Cut
echo "******************"; // Cut
echo chr(1);
echo chr(2);
echo chr(3);
echo chr(4);
echo chr(5);
exit(0);

$test "

@!3

@@aHello World
!aESC/POS Printer Test
!aGoodbye World
VA";


