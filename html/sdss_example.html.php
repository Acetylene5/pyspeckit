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
                <h3>Optical fitting: The H<sub>&alpha;</sub>-[NII] complex of a type-I Seyfert galaxy</h3>
                
            <code class="prettyprint">
import pyspeckit

# Rest wavelengths of the lines we are fitting - use as initial guesses
NIIa = 6549.86
NIIb = 6585.27
Halpha = 6564.614
SIIa = 6718.29
SIIb = 6732.68

# Initialize spectrum object and plot region surrounding Halpha-[NII] complex
spec = pyspeckit.Spectrum('sample_sdss.txt', errorcol=2)
spec.plotter(xmin = 6450, xmax = 6775, ymin = 0, ymax = 150)

# We fit the [NII] and [SII] doublets, and allow two components for Halpha.  The widths of all narrow lines are tied to the widths of [SII].
guesses = [50, NIIa, 5, 100, Halpha, 5, 50, Halpha, 50, 50, NIIb, 5, 20, SIIa, 5, 20, SIIb, 5]
tied = ['', '', 'p[17]', '', '', 'p[17]', '', 'p[4]', '', '3 * p[0]', '', 'p[17]', '', '', 'p[17]', '', '', '']

# Actually do the fit.
spec.specfit(guesses = guesses, tied = tied, annotate = False)
spec.plotter.refresh()

# Let's use the measurements class to derive information about the emission lines.  The galaxy's redshift and the flux normalization of the spectrum must be supplied to convert measured fluxes to line luminosities.  If the spectrum we loaded in FITS format, 'BUNITS' would be read and we would not need to supply 'fluxnorm'.
spec.measure(z = 0.05, fluxnorm = 1e-17)

# Now overplot positions of lines and annotate

y = spec.plotter.ymax * 0.85    # Location of annotations in y

for i, line in enumerate(spec.measurements.lines.keys()):

    # If this line is not in our database of lines, don't try to annotate it
    if line not in spec.speclines.optical.lines.keys(): continue

    x = spec.measurements.lines[line]['modelpars'][1]   # Location of the emission line 
    spec.plotter.axis.plot([x]*2, [spec.plotter.ymin, spec.plotter.ymax], ls = '--', color = 'k')   # Draw dashed line to mark its position
    spec.plotter.axis.annotate(spec.speclines.optical.lines[line][-1], (x, y), rotation = 90, ha = 'right', va = 'center')  # Label it

# Make some nice axis labels
spec.plotter.axis.set_xlabel(r'Wavelength $(\AA)$')
spec.plotter.axis.set_ylabel(r'Flux $(10^{-17} \mathrm{erg/s/cm^2/\AA})$')
spec.plotter.refresh()

# Print out spectral line information
print "Line   Flux (erg/s/cm^2)     Amplitude (erg/s/cm^2)    FWHM (Angstrom)   Luminosity (erg/s)"
for line in spec.measurements.lines.keys():
    print line, spec.measurements.lines[line]['flux'], spec.measurements.lines[line]['amp'], spec.measurements.lines[line]['fwhm'], \
        spec.measurements.lines[line]['lum']
        
# Had we not supplied the objects redshift (or distance), the line luminosities would not have been measured, but integrated fluxes would still be derived.  Also, the measurements class separates the broad and narrow H-alpha components, and identifies which lines are which. How nice!

spec.specfit.plot_fit()

# Save the figure
spec.plotter.figure.savefig("sdss_fit_example.png")

        </code>
    </td></tr>
    <tr><td>
            <br> The results:
            <br>
<code>            
Line  Flux (erg/s/cm^2)  Amplitude (erg/s/cm^2) FWHM (Angstrom) Luminosity (erg/s) <br>
NIIa 1.59280798003e-15 2.48559532114e-16 6.02005958701 9.38307759724e+39 <br>
NIIb 4.77842394008e-15 7.45678596342e-16 6.02005958701 2.81492327917e+40 <br>
SIIb 1.32667180265e-15 2.07028673054e-16 6.02005958701 7.81529514317e+39 <br>
SIIa 1.41963574314e-15 2.21535803759e-16 6.02005958701 8.36293671602e+39 <br>
H_alpha_B 4.43959506868e-14 5.42064119973e-16 76.9414716115 2.61532247152e+41 <br>
H_alpha_N 4.56987114603e-15 7.13133691017e-16 6.02005958701 2.69206684737e+40 <br>
H_alpha 4.89658218328e-14 1.25519781099e-15 11.0611083985 5.76905831251e+41 <br>   
</code>  
<br>   <br>             
            
    <img align=center width=800 src=images/sdss_fit_example.png title="Both transitions are fit simultaneously using a RADEX model.  The input (fitted) parameters are therefore density, column density, width, and velocity.">
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
