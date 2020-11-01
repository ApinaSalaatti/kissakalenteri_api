# kissakalenteri_api
A super simple API that returns images used by the Kissakalenteri.

Currently the endpoints are:
`/{year}/{day}` which returns an image for the cat of that day
`/{year}/{day}/thumb` which returns a 100x100 pixel thumbnail for the day's cat

Both endpoints check that the given day is valid, i.e. that it's not in the future (because that's CHEATING!)