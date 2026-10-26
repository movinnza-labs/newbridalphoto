#!/usr/bin/env bash
# Checks every old/legacy URL from the SEO traffic drop analysis (Sept 2026).
# For each URL prints: first status, first Location, number of hops, final status, final URL.
# A good result is: 301, 1 hop, final 200.  Anything else is flagged with "!!".
#
# Usage:  bash tools/check_redirects.sh [BASE_URL]
#   local: bash tools/check_redirects.sh http://localhost:8080/thebridal
#   live:  bash tools/check_redirects.sh https://thebridal.photography
# Uses GET (not HEAD) so the result matches what Googlebot sees.

BASE="${1:-http://localhost:8080/thebridal}"
BASE="${BASE%/}"

URLS=(
# Section 8.1 / Step 3.1: double moves
/blog/pre-wedding-shoot-locations-in-mumbai/
/blog/top-7-pre-wedding-shoot-location-in-satara/
/pre-wedding-shoot-location-satara/
/blog/5-destinations-for-a-pre-wedding-shoot-in-goa/
/5-destination-for-a-pre-wedding-shoot-in-goa/
/goa/pre-wedding-shoot-in-goa/
# Section 8.5 / Step 2: old URLs with no clear home
/pre-wedding-shoot/
/wedding-photographer-pune/
/packages/
/mumbai/wedding-photographers/
/maternity-photography-packages/
/goa/engagement-photographers-in-goa/
/private-jet-shoot/
/wedding-photography-mahabaleshwar/
# Section 8.6: misspelled old URLs
/goa/wedding-photoraphers-in-goa/
/ahilyanagar/wedding-photoraphers-in-ahilyanagar-thebridal-photoraphy/
# Appendix
/best-locations-for-a-maternity-photoshoot-in-pune/
/pre-wedding-photoshoots-in-lakshadweep-island-india/
/mumbai/engagement-photo-shoot/
/lavasa-city-a-prewedding-paradise-for-couples/
/pre-wedding-shoot-at-snap-city-pune/
/pre-wedding-destinations-in-mahabaleshwar/
/housewarming-ceremony-photography-services/
/baby-shower-shoot/
/engagement-photo-shoot/
/pre-wedding-shoot-pba-film-city/
/roka-ceremony-shoot-ring-ceremony-shoot-in-pune/
/when-should-i-take-my-pre-wedding-shoot-2024/
/birthday-photography-services/
/capturing-love-in-the-serenity-of-mulshi/
/capturing-love-in-the-lap-of-luxury-in-lonavala/
/capturing-love-in-the-lap-of-luxury-trending-pre-wedding-destinations-in-lonavala/
/newborn-photography-services/
# Section 10 / Step 4: duplicate pages
/blog/when-should-i-take-my-pre-wedding-shoot/
/candid-birthday-photography-tips/
# Section 8.6: no-slash versions (must 301 to the slash version)
/pre-wedding-shoot-locations-in-pune
/maternity-photographer-pune
/pre-wedding-shoot-locations-mumbai
/pre-wedding-shoot-locations-in-mumbai
/when-to-take-pre-wedding-shoot
)
# Extra URLs added during the fix (duplicate merges etc.) are appended below.
EXTRA_FILE="$(dirname "$0")/check_redirects_extra.txt"
if [ -f "$EXTRA_FILE" ]; then
  while IFS= read -r line; do
    line="${line%%#*}"; line="$(echo "$line" | tr -d '[:space:]')"
    [ -n "$line" ] && URLS+=("$line")
  done < "$EXTRA_FILE"
fi

# Old URLs approved to 301 to the homepage (D2, D10 in SEO_FIX_NOTES.md)
ALLOW_HOME="/wedding-photographer-pune/ /bridal-photography-pune/"

printf "%-78s %-5s %-4s %-5s %s\n" "OLD URL" "FIRST" "HOPS" "FINAL" "FINAL URL"
bad=0
for path in "${URLS[@]}"; do
  url="$BASE$path"
  first=""; firstloc=""; hops=0; cur="$url"; code=""
  while :; do
    out=$(curl -s -o /dev/null -w "%{http_code} %{redirect_url}" --max-time 20 "$cur")
    code="${out%% *}"; loc="${out#* }"; [ "$loc" = "$code" ] && loc=""
    [ -z "$first" ] && { first="$code"; firstloc="$loc"; }
    case "$code" in
      301|302|303|307|308)
        hops=$((hops+1)); cur="$loc"
        [ $hops -ge 6 ] && { code="LOOP"; break; } ;;
      *) break ;;
    esac
  done
  final="${cur#$BASE}"
  flag=""
  if [ "$first" != "301" ] || [ $hops -ne 1 ] || [ "$code" != "200" ]; then flag="!!"; bad=$((bad+1)); fi
  # A redirect to the homepage is only OK where it was approved (the homepage owns the keyword)
  case " $ALLOW_HOME " in *" $path "*) ;; *)
    [ "$first" = "301" ] && [ "$final" = "/" ] && { flag="!! HOME"; bad=$((bad+1)); } ;;
  esac
  printf "%-78s %-5s %-4s %-5s %s %s\n" "$path" "$first" "$hops" "$code" "$final" "$flag"
done
echo
echo "URLs checked: ${#URLS[@]}   Problems: $bad"
