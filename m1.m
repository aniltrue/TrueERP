x=input("Please enter a number");
y=1;
for (i=2:x)
p=0;
for (j=2:(i-1))
if (mod(i,j)==0)
p++;
endif
endfor
if (p==0)
for (j=1:y)
if (j!=1)
fprintf(",");
endif
fprintf("%d",i);
endfor
fprintf("\n");
y++;
endif
endfor
