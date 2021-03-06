<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="prettify.css" type="text/css" rel="stylesheet">
        <link rel="icon" type="image/gif" href="images/logo.ico">
        <script type="text/javascript" src="prettify.js"></script>
        <title> PySpecKit - Examples </title>
        <h2> Examples </h2>
    </head>
    <br>
    <br>
<body onload="prettyPrint()"> 
    <center>
    <table width=800>
        <tr><td>
                <br><br>
                <h3>Fitting a Doublet, and Deriving the Redshift </h3>
                
            <code class="prettyprint">
import pyspeckit

# Read in J000002.09+155254.1 spectrum, a nice emission-line galaxy
sp = pyspeckit.Spectrum('../tests/SIIdoublet.fits')

# Read in rest wavelengths of SII lines.  If you didn't know the names already, 
# you could do sp.speclines.optical.lines.keys() to see what is available.
SIIa = sp.speclines.optical.lines['SIIa'][0]
SIIb = sp.speclines.optical.lines['SIIb'][0]

# Wavelength difference between doublet lines - use to tie positions together
offset = SIIb - SIIa

# Let's have a look at the spectrum
sp.plotter()

raw_input('Let\'s do a simple continuum subtraction (continue)')

# Plot the baseline fit
sp.baseline(subtract = False)

raw_input('Let\'s zoom in on the SII doublet (continue)')

# Subtract the baseline fit and save
sp.baseline()
sp.plotter.savefig('doublet_example_fullspectrum.png')

# Guess for the redshift - otherwise we'll end up with the Halpha-NII complex
z = 0.02        

# Zoom in on SII doublet
sp.plotter(xmin = SIIa * (1 + z) - 75, xmax = SIIb * (1 + z) + 75, ymin = -10, ymax = 60)

# Guess amplitudes to be 100, positions to be rest wavelengths 
# times factor (1 + z), and widths to be 5 Angstroms
guesses = [100, SIIa * (1 + z), 5, 100, SIIb * (1 + z), 5]
tied = ['', '', '', '', 'p[1] + %g' % offset, '']

# Do the fit, and plot it
sp.specfit(guesses = guesses, tied = tied, quiet = False)
sp.plotter.savefig('doublet_example_SII.png')
              
raw_input('Hooray! The doublet has been fit. ')

SIIb_obs = sp.specfit.modelpars[-2]

print 'Our guess for the redshift was z = 0.02.'
print 'The redshift, as derived by the line shift, is z = %g' % ((SIIb_obs / SIIb) - 1)

        </code>
    </td></tr>
    <tr><td>
<br>   <br>             
            
    <img align=center width=800 src=images/doublet_example_fullspectrum.png title="">
    <img align=center width=800 src=images/doublet_example_SII.png title="">
    </td></tr>
    </table>
    <?php include 'navbar.php';?>
    </center>
    
  </body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6253200-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  
</html>
