
import matplotlib as mpl
import numpy as np

def colorFader(c1,c2,mix=0): #fade (linear interpolate) from color c1 (at mix=0) to c2 (mix=1)
    c1=np.array(mpl.colors.to_rgb(c1))
    c2=np.array(mpl.colors.to_rgb(c2))
    return mpl.colors.to_hex((1-mix)*c1 + mix*c2)

c1='red' #blue
c2='blue' #green
c3='green' #green

cols = []
N = 2*5
for i in range(0,N//2):
    cols.append(colorFader(c1,c2,i/(N/2)))
          
for i in range(0,N//2):
    cols.append(colorFader(c2,c3,i/(N/2)))

print(cols)

