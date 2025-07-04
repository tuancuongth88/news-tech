<?php
function getRainLevelDescription($precipitation)
{
    if ($precipitation == 0) return 'Không mưa';
    if ($precipitation <= 0.3) return 'Mưa phùn nhẹ';
    if ($precipitation <= 2.5) return 'Mưa nhẹ';
    if ($precipitation <= 7.6) return 'Mưa vừa';
    return 'Mưa to';
}
