# Technical issues found while proofreading (23 Oct 2026)

These were NOT changed. Language errors were corrected in place; FAQs were left untouched.
Every internal link on the checked pages points to a real route.

## Sitewide
| Where | Issue | Suggested correction |
|---|---|---|
| Header, Wedding menu | The `wedding` check also matches `pre-wedding` URLs, so both menus highlight on pre-wedding pages | `str_contains($currentUrl,'wedding') && !str_contains($currentUrl,'pre-wedding')` |
| Footer, Services column | "About Us" is listed as a service | Move it to the bottom nav or rename the column |
| Contact cards (several pages) | Phone written as "+91 8390367637" and "+91 83903 67637" | Use "+91 83903 67637" everywhere |
| Testimonials (city pages) | Couple names are `<h3>` headings | Use `<p>` or `<cite>` |

## Homepage
| Section | Issue | Suggested correction |
|---|---|---|
| Services grid | "View All 12 Services", but /services/ lists 13 | "View All 13 Services", or drop the number |
| Hero stats | "1,179 Reviews" equals "1,179+ Happy Couples" | Confirm both numbers |
| Hero / intro | "Pune & Mumbai", "3 Branches" and a list of five cities | Make the city and branch claims consistent |
| City hubs | "Ahmednagar district" | "Ahilyanagar district" |
| Why Choose Us | "Support 24/7" box has no text; "Adding the memories of every moment" | Add a line or remove the box; "Preserving the memories of every moment" |
| What We Offer | Alt text "holding an Its Boy sign" | "It's a Boy sign" (check image) |
| FAQ 1 | "10 years of experience" vs "since 2014"; uses "I think" and "your videographer" | "10+ years"; use "we"; "your photographer" |

## Wedding Films
| Section | Issue | Suggested correction |
|---|---|---|
| What you get | Teaser and 3–4 min film read as included in every package; Packages list puts the cinematic film in Diamond only | State which package includes which film |
| FAQ | 25-day video delivery vs "15 to 45 days" on the wedding packages FAQ | Use one timeline on both pages |

## Destination wedding venues
| Section | Issue | Suggested correction |
|---|---|---|
| Venue 2 | "Changvateshwer" is probably misspelt | Check: likely "Changa Vateshwar" (near Saswad) |
| Venues 2 and 4 | Image file names look swapped | Look at both photos; swap src + size + alt together only if wrong |
| Venue 4 | Marigold Banquets (a banquet hall) is under "Heritage & Historical Venues" | Move it, or confirm |
| Sunny's World | Text "October to February" vs Best Time "November to February" | Use one |
| Venues 10–17 | No "Type of Venue" line; Wildernest has no "Perfect Time"; one-line intros | Content gap (needs writing) |
| Dhepe Wada | Facility "Heritage wedding" is not a facility | "Heritage wedding setup/decor" |
| FAQ | "Drones allowed at all venues"; "most venues allow valet parking" (only Marigold lists it) | Say drones need venue + DGCA permission; correct parking claim |

## Pune locations
| Section | Issue | Suggested correction |
|---|---|---|
| Khadakwasla | "Blazing sun rays… before sunrise"; distance as "40-minute drive" | "around sunrise or sunset"; give km (about 20 km) |
| Saras Baug | "close to Pune" (it is in the city) | "in the heart of Pune" |
| Empress Garden | Heading says Hadapsar; it is in Pune Cantonment. "Private setting without distractions" in a public garden | Fix area; soften the claim |
| Pixel City | "more than 30 different features" | "sets" |
| The Bhor | Venue's own "drone package" vs "drone shots with photography packages" | Pick one |
| Several venues | "Our team will provide the changing room" (venue facility; unlikely at an ancient temple) | "Changing rooms are available" or confirm per venue |
| Hero / intro | Promises fees and distances for every place; 8 places have none | Add them or say "where available" |
| Lavasa / Plan B | "Mulshi Dam" vs "Mulshi Lake" | One name |
| Pune Street | "1.2 km from the city"; "country-like environments" | "from the city centre"; "old-world heritage surroundings" |
| Intro | "we always understand your pace" is unclear | Confirm wording (pace / taste / preferences) |
| Distances (from earlier fix) | Viva ~20 km, Nature's Paradise ~70 km, Sangameshwar ~30 km are estimates | Client to confirm |

## Pre-wedding packages
| Section | Issue | Suggested correction |
|---|---|---|
| Hero | "Starting from ₹14,999" while a ₹9,999 plan exists | "Packages from ₹14,999 (budget plan ₹9,999)" |
| Diamond | Detail list lacks "2-day shoot"; Bali/Maldives/Paris at ₹55,555 | Add duration; "travel and stay charged at actual cost" |
| Packages vs Deliverables | "3 min song + 1 min reel" vs "3–4 min film + 1 min teaser"; a "Traditional film" no package includes | Align names and lengths; drop traditional film |
| Deliverables, Videos | No "Platinum and Diamond only" note (Gold has no video) | Add the note |
| Delivery times | 15/25 days shown only under Diamond | Show for all packages once |
| Terms, travel | "Crew eats with the guests" (no guests at a pre-wedding shoot); repeats the stay bullet | Merge and reword |
| Add-ons | Two separate add-on blocks | Merge or separate visually |
| Raw photos | FAQ says raw costs extra (₹6,500 drive); budget page gives all raw free | State the policy per package |
| FAQ | "Same-day editing" mentioned but not offered; camera list differs from quick facts | Align with the page |

## Budget (under ₹10,000)
| Section | Issue | Suggested correction |
|---|---|---|
| Session | "our photographers" vs "1 Candid Photographer" | "our photographer" |
| Why Pune / Stands Out | "wedding photography" | "pre-wedding photography" |
| Locations intro | "This place / This location" without naming them | Name them or use a one-line intro |
| Tips | "Consult the photographer" text is about transport | "Discuss locations, timing and travel with your photographer in advance" |
| Booking | "Visit Our Website" (already on it) | "Browse our portfolio" |
| Highlights | H3 cards with no H2 above | Add "What's Included" H2 |

## Satara
| Section | Issue | Suggested correction |
|---|---|---|
| Thoseghar | "near the Satara district" (it is inside it) | "about 20 km from Satara city" |
| Vajrai | Height 145 m is doubtful (usually cited ~560 m); "short hike" understates access | Verify height; describe trek / boat access |
| Kaas | Called a UNESCO site by itself | "part of the Western Ghats UNESCO World Natural Heritage Site" |
| Chalkewadi | "consumer-spy photos"; "small rivers" | "quirky poses"; verify |
| Images | Windmill, Vajrai, Ajinkyatara and Kaas images don't show those places | Use real location photos |
| Pro Tips | Marked up as h4 | `<p><strong>Pro Tip:</strong>` |

## Goa
| Section | Issue | Suggested correction |
|---|---|---|
| Days vs Charges vs FAQ | Recommends 2+ days; price and FAQ assume 1 day | Align |
| Days & Schedule | Bat Island called "hinterland" (it is offshore); Chorla + Bat Island in one day | Fix; plan on separate days |
| Beach timing | "6–10 AM / 3–7 PM = golden hours"; contradicts "avoid afternoon" | "sunrise (6–8 AM) or late evening (5–7 PM)" |
| Tips | "Get a local photographer" undercuts the studio | "work with a photographer who knows Goa" |
| Other locations | Repeats Days & Schedule paragraph | Remove one |
| Images | Hero and intro reuse one image with different alts; Chorla/Panjim/Mandovi/Bat Island images don't match | Use matching photos |
| Related pages | Links /wedding-photography-packages/ | /pre-wedding-photography-packages/ |
| Starting price | Not confirmed (from earlier fix) | Client to confirm |

## Timing guide
| Section | Issue | Suggested correction |
|---|---|---|
| Concept themes | "Western theme… wear traditional clothes to a ranch" | "cowboy-style outfits at a ranch" |
| Pune list | "Forts, gardens, temples and lakes" with no lake named | "Forts, palaces, gardens and temples" |
| Closing | "Visit our website" | "Explore our portfolio" |
| Winter heading | "October to February" vs "mid-October" | "Mid-October to February" |

## Engagement / Roka / Maternity / Baby shower
| Page, section | Issue | Suggested correction |
|---|---|---|
| Engagement, quick facts | "Full ceremony + candid" but Gold is 3 h, no candid | "3–4 hours; candid from Platinum" |
| Engagement, Gold | "close-knit weddings" | "close-knit engagements" |
| Engagement, Diamond | "Traditional Videography: live streaming" | "Full-length video coverage" |
| Engagement, Diamond | "3-minute song (2 to 3 min)" vs Deliverables "3–4 min film"; "250 Images" vs "45 edited" | Align length and photo counts |
| Engagement, Why Choose | Intro says "following add-ons" but lists reasons | "Here's why couples choose us:" |
| Engagement, Cancellation | Policy gives no terms; FAQ promises full refund 8+ days before | Add the term |
| Engagement, equipment | "flashlights (AD-200, AD-400)" | "flashes (Godox AD-200, AD-400) and video lights" |
| Engagement, terms | "air travel, local transport." incomplete | "…are charged to the client." |
| Engagement, FAQ | Q2 says the client provides photos; Q5 says all packages are candid (Gold isn't) | Fix wording / facts |
| Roka | "pre-engagement" (×2) | "engagement" |
| Roka | US spelling vs Indian/British elsewhere | Standardise |
| Maternity | Repeated bold keyword phrases | Reduce |
| Maternity | "Digital photography as optional extras" | "extra digital images" or remove |
| Baby shower, Diamond | Lacks "Candid Photography" that Platinum has | Add if included |
| Baby shower, Videos | Film reads as included for all packages | "Videos (Platinum & Diamond)" |
| Baby shower, intro | "In this article" | "On this page" |
| Baby shower | Two near-identical "Benefits…" headings | Rename one |

## Ahilyanagar
| Page, section | Issue | Suggested correction |
|---|---|---|
| Pre-wedding, gallery | Alts describe Shaniwar Wada (Pune) and beaches | Use Ahilyanagar photos or neutral alts |
| Engagement, destinations | "Home wedding moments" | "Home engagement / ring ceremony moments" |
| Wedding, venues | Banquet card text is not about banquet halls | Rewrite to describe banquet-hall photography |
| Wedding | "Quick turnaround" with no timeline | Add a timeline or "Timely delivery" |
| Baby | "Newborn 5–14 days" vs "Newborn (0–3 months)" | One definition |
| Baby, FAQ | Photos "within a couple of days" vs 7/10/15 days; sessions "1–3 hours" vs Diamond full day | Align |
| Baby | Gold labelled "Studio" while page promotes home shoots; prices taken from Pune pages | Client to confirm |
